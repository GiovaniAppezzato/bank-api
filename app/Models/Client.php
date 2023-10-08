<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'birth',
        'sex',
        'region',
        'neighborhood',
        'address',
    ];

    public function accounts()
    {
        return $this->hasOne(Account::class);
    }

    public function cards() // Is this really necessary... like... for real?
    {
        return $this->hasMany(Cards::class);
    }
        
}
