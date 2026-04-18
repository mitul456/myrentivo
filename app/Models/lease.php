<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'status',
    ];

    protected static function booted()
    {
        // যখন lease create হয়
        static::created(function ($lease) {
            $lease->unit->update([
                'status' => 'occupied'
            ]);
        });

        // যখন lease update হয়
        static::updated(function ($lease) {
            if ($lease->status === 'ended') {
                $lease->unit->update([
                    'status' => 'vacant'
                ]);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}