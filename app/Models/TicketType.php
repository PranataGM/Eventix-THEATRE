<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketType extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quota',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getRemainingQuotaAttribute()
    {
        // Calculate tickets that are pending or confirmed
        $sold = $this->registrations()->whereIn('status', ['confirmed', 'pending'])->count();
        return max(0, $this->quota - $sold);
    }
}
