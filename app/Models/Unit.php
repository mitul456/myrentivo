<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'property_id',
        'unit_number',
        'floor',
        'rent_amount',
        'status',
    ];

    // Each Unit belongs to one Property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
