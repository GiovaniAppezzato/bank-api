<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'amount',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
