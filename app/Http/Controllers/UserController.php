<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Savings;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $account = Account::create(['user_id' => $user->id]);

        Savings::create(['account_id' => $account->id]);

        return response()->json([
            'user' => $user
        ], 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data);

        return response()->json([
            'user' => $user
        ], 200);
    }
}
