<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'city',
        'country',
        'total_units'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // One Property has many Units
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
