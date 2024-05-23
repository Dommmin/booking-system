<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted(): void
    {
        static::creating(function (Appointment $appointment): void {
            $appointment->uuid = str()->uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function scopeNotCancelled($query)
    {
        return $query->whereNull('cancelled_at');
    }
}
