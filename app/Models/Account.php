<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'number',
        'balance',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function savings()
    {
        return $this->hasOne(Savings::class, 'account_id');
    }

    public function pix_keys()
    {
        return $this->hasMany(PixKey::class);
    }

    public function pix_movements()
    {
        return $this->hasMany(PixMovement::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
