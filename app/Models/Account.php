<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'client_id',
        'balance',
        'password',
    ];

    public function transfers()
    {
        $this->hasMany(Transfer::class);
    }

    public function cards()
    {
        $this->hasMany(Card::class);
    }
}
