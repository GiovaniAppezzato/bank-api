<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'transaction_type',
        'transaction_id',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
