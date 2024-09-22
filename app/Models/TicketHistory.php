<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketHistory extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'user_id', 'previous_ticket_status_id', 'current_ticket_status_id', 'reason'];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function previousTicketStatus(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'previous_ticket_status_id');
    }

    public function currentTicketStatus(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'current_ticket_status_id');
    }
}
