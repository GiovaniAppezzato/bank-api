<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Savings;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function store(StoreUserRequest $request): Response
    {
        $data = $request->validated();
        $user = User::create($data);
        $account = Account::create(['user_id' => $user->id]);

        Savings::create(['account_id' => $account->id]);
        Address::create(['user_id' => $user->id]);

        return response()->json([
            'user' => $user
        ], 201);
    }

    public function update(UpdateUserRequest $request, User $user): Response
    {
        $data = $request->validated();
        $user->update($data); //QUESTION: Do i need to add "photo_path" in here?

        $photoPath = null;

        if ($request->hasFile('user.photo')) {
            $photoPath = $request->file('user.photo')
            ->store('photos', 
            Auth::id() . '.' . $request->file('user.photo')->getClientOrginalExtension(), 
            'public');
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }

    public function resetPasswordLogged(User $user, Request $request)
    {
        //TODO: Update if the old password is different and if both passwords are equal.

        $this->validate($request, [
            'new_password' => 'required|confirmed|min:8',
        ]);

        $newPassword = $request->input('new_password');

        $user->update([
            'password' => bcrypt($newPassword),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully',
        ], 200);
    }
}
