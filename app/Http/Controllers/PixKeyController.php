<?php

namespace App\Http\Controllers;

use App\Models\PixKey;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePixKeyRequest;
use App\Http\Requests\UpdatePixKeyRequest;

class PixKeyController extends Controller
{
    public function store(StorePixKeyRequest $request)
    {
        $data = $request->validated();

        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $pixKey = PixKey::create([
            'name'       => $data->name,
            'status'     => $data->status,
            'account_id' => $account->id
        ]);

        return response()->json([
            'pixKey' => $pixKey
        ], 200);
    }

    public function destroy(PixKey $pixKey)
    {
        $pixKey->destroy($pixKey);

        return response()->json(['message' => 'The pix key has been deleted'], 200);
    }
}
