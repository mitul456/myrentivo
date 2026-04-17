<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lease_id',
        'amount',
        'payment_date',
        'month',
        'status',
        'payment_method',
        'notes',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
