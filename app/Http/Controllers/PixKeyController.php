<?php

namespace App\Http\Controllers;

use App\Models\PixKey;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePixKeyRequest;

class PixKeyController extends Controller
{
    public function store(StorePixKeyRequest $request)
    {
        $data = $request->validated();

        $account = Account::findOrFail(Auth::id());

        $pixKey = PixKey::create([
            'name'       => $data->name,
            'status'     => $data->status,
            'account_id' => $account->id
        ]);

        return response()->json([
            'pixKey' => $pixKey
        ], 200);
    }

    public function update(UpdatePixKeyRequest $request)
    {
        $data = $request->validated();

        $pixKey->update($data);

        return response()->json([
            'pixKey' => $pixKey
        ], 200);
    }

    public function destroy()
    {
        $pixKey->destroy();

        //QUESTION: Is this all?
    }
}
