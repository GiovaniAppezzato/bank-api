<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
        'savings_id'
    ];

    public function savings()
    {
        $this->belongsTo(Savings::class, 'savings_id');
    }
}
