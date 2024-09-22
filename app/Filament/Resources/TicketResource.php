<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ticket_type_id')->label('Ticket Type')
                ->options(TicketType::pluck('description', 'id'))->required(),
                Forms\Components\Select::make('user_id')->label('Created By')
                    ->options(User::pluck('name', 'id'))->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\Textarea::make('reason')->label('Edit Reason')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticketType.type')->label('Type'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('ticketStatus.description')->label('Status'),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime(),
                Tables\Columns\TextColumn::make('createdBy.name')->label('Created By')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Escalate')
                    ->action(fn (Ticket $record) => $record->escalate())
                    ->requiresConfirmation()
                    ->color('danger'),
                Tables\Actions\Action::make('Resolve')
            ->requiresConfirmation()
                ->color('success')
                ->mountUsing(function (Forms\ComponentContainer $form, Ticket $ticket){
                    //
                })->form([
                        Textarea::make('reason')
                            ->required()
                    ])->action(function (array $data, Ticket $ticket){
                        $prev = $ticket->ticket_status_id;
                        $ticket->update([
                            'is_resolved' => true,
                            'resolved_by_user_id' => auth()->user()->id,
                            'resolved_at' => Carbon::now(),
                            'ticket_status_id' => TicketStatus::resolved()->id
                        ]);
                        // Creating history
                        $ticket->histories()->create([
                            'user_id' => auth()->user()->id,
                            'previous_ticket_status_id' => $prev,
                            'current_ticket_status_id' => TicketStatus::resolved()->id,
                            'reason' => $data['reason'],
                        ]);
                        $ticket->save();
                    }),
                Tables\Actions\Action::make('Update')
                    ->mountUsing(function (Forms\ComponentContainer $form, Ticket $record) {
                        $form->fill([
                            'ticket_status_id' => $record->ticket_status_id,
                            'ticket_type_id' => $record->ticket_type_id,
                        ]);
                    })
                    ->form([
                        Select::make('ticket_status_id')
                            ->options(TicketStatus::pluck('description', 'id'))
                            ->required(),
                        Select::make('ticket_type_id')
                            ->options(TicketType::pluck('description', 'id'))
                            ->required(),
                        Textarea::make('reason')
                            ->required()
                    ])
                    ->action(function (array $data, Ticket $record): void {
                        $prev = $record->ticket_type_id; // Use $record, not $this->record
                        $record->ticket_status_id = $data['ticket_status_id'];
                        $record->ticket_type_id = $data['ticket_type_id'];

                        // Creating history
                        $record->histories()->create([
                            'user_id' => auth()->user()->id,
                            'previous_ticket_status_id' => $prev,
                            'current_ticket_status_id' => $data['ticket_status_id'],
                            'reason' => $data['reason'],
                        ]);

                        // Save the updated record
                        $record->save();
                    })
                    ->color('info'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\HistoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
