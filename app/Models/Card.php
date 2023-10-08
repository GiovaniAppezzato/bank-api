<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
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
        $this->belongsTo(Account::class); //Many? Maybe?
    }
}
