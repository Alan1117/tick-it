<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TicketStatus extends Model
{
    use HasFactory;
    protected $fillable = ['description'];

    public static function submitted()
    {
        return Cache::rememberForever('submitted_ticket_status',function() {
           return self::firstOrCreate(['description' => 'Submitted']);
        });
    }

    public static function open()
    {
        return Cache::rememberForever('open_ticket_status',function() {
            return self::firstOrCreate(['description' => 'Open']);
        });
    }

    public static function inProgress()
    {
        return Cache::rememberForever('in_progress_ticket_status',function() {
            return self::firstOrCreate(['description' => 'In Progress']);
        });
    }

    public static function resolved()
    {
        return Cache::rememberForever('resolved_ticket_status',function() {
            return self::firstOrCreate(['description' => 'Resolved']);
        });
    }

    public static function reopened()
    {
        return Cache::rememberForever('reopened_ticket_status',function() {
            return self::firstOrCreate(['description' => 'Reopened']);
        });
    }

    public static function escalated()
    {
        return Cache::rememberForever('escalated_ticket_status',function() {
            return self::firstOrCreate(['description' => 'Escalated']);
        });
    }
}
