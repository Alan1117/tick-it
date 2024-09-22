<?php

namespace App\Filament\Resources;

use App\Enums\PriorityTypes;
use App\Filament\Resources\TicketTypeResource\Pages;
use App\Filament\Resources\TicketTypeResource\RelationManagers;
use App\Models\TicketType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketTypeResource extends Resource
{
    protected static ?string $model = TicketType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\Select::make('priority')
                    ->options(collect(PriorityTypes::cases())->mapWithKeys(fn($case) => [
                        $case->value => ucfirst($case->value),
                    ])->toArray())->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('priority')->badge()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('priority')->options(collect(PriorityTypes::cases())->mapWithKeys(fn($case) => [
                    $case->value => ucfirst($case->value),
                ])->toArray())
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicketTypes::route('/'),
            'create' => Pages\CreateTicketType::route('/create'),
            'edit' => Pages\EditTicketType::route('/{record}/edit'),
        ];
    }
}
