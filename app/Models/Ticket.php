<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['resolved_by_user_id', 'ticket_status_id',
        'ticket_type_id', 'description', 'created_by_user_id',
        'is_resolved', 'resolved_at', 'resolved_by_user_id'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by_user_id');
    }

    public function ticketStatus(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function escalate()
    {
        $previous = $this->ticket_status_id;
        $this->update(['ticket_status_id' => TicketStatus::escalated()->id]);
        $this->histories()->create([
            'previous_ticket_status' => $previous,
            'current_ticket_status' => $this->ticket_status_id,
            'user_id' => auth()->user()->id,
            'reason' => 'Escalated Support Ticket'
        ]);
    }

    public function resolve()
    {
        $previous = $this->ticket_status_id;
        $this->update([
            'ticket_status_id' => TicketStatus::resolved()->id,
            'resolved_by_user_id' => auth()->user()->id,
            'resolved_at' => Carbon::now(),
            'is_resolved' => true
        ]);
        $this->histories()->create([
            'previous_ticket_status' => $previous,
            'current_ticket_status' => $this->ticket_status_id,
            'user_id' => auth()->user()->id,
            'reason' => 'Resolved Ticket'
        ]);
    }
}
