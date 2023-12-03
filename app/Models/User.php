<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'cpf',
        'password',
        'birth',
        'sex',
        'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth'             => 'datetime:Y-m-d',
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function newAccount($request)
    {
        $user = $this->create($request->validated());

        $randomNumberPart1 = rand(1000000, 9999999);
        $randomNumberPart2 = rand(1, 9);
        $randomNumber = $randomNumberPart1 . '-' . $randomNumberPart2;
        $account = $user->account()->create([ "number" => $randomNumber]);

        $account->savings()->create();

        return $user;
    }
}
