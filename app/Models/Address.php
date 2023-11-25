<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
        'zip_code',
        'user_id',
        'state'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
