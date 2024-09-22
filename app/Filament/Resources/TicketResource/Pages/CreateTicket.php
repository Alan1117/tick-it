<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;


    protected function handleRecordCreation(array $data): Model
    {
        $ticket = Ticket::create([
            'ticket_status_id' => TicketStatus::submitted()->id,
            'user_id' => $data['user_id'],
            'ticket_type_id' => $data['ticket_type_id'],
            'description' => $data['reason']
        ]);
        $ticket->histories()->create([
            'user_id' => auth()->user()->id,
            'previous_ticket_status' => null,
            'current_ticket_status' => $ticket->ticket_status_id,
            'reason' => $data['reason']
        ]);
        return $ticket;
    }
}
