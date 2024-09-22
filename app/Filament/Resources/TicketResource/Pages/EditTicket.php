<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\TicketType;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getFormSchema(): array
    {
        return [
            Select::make('ticket_status_id')->options(TicketStatus::pluck('description', 'id'))->required(),
            Select::make('ticket_type_id')->options(TicketType::pluck('description', 'id'))->required(),
            Textarea::make('reason')->required()
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $previousStatus = $record->ticket_status_id;
        $record->update([
            'ticket_status_id' => $data['ticket_status_id'],
            'ticket_type_id' => $data['ticket_type_id'],
        ]);
        $record->histories()->create([
            'user_id' => auth()->user()->id,
            'previous_ticket_status' => $previousStatus,
            'current_ticket_status' => $record->ticket_status_id,
            'reason' => $data['reason']
        ]);
        return $record;
    }
}
