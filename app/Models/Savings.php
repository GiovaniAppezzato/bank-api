<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'savings';

    protected $fillable = [
        'balance',
        'account_id'
    ];

    public function savingsMovements()
    {
        return $this->hasMany(SavingsMovement::class, 'savings_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
