<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'amount',
        'sender_id',
        'receiver_id',
    ];

    public function accounts()
    {
        $this->belongsToMany(Account::class);
    }
}