<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PixKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'status',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function pix_movements()
    {
        return $this->hasMany(PixMovement::class);
    }
}
