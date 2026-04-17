<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'title',
        'amount',
        'expense_date',
        'note',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
