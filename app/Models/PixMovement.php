<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PixMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'amount',
        'account_id',
        'pix_key_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function pix_keys()
    {
        return $this->belongsTo(PixKey::class);
    }
}
