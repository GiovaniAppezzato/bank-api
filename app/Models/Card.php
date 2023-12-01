<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'password',
        'credit_limit',
        'expiration_date',
        'is_blocked',
        'account_id'
    ];

    public function account()
    {
        $this->belongsTo(Account::class);
    }
}
