<?php

namespace App\Http\Controllers;

use App\Models\PixKey;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePixKeyRequest;

class PixKeyController extends Controller
{
    public function index()
    {
        $pixKeys = Auth::user()->account->pix_keys;

        return response()->json([
            'pixKeys' => $pixKeys
        ], 200);
    }

    public function store(StorePixKeyRequest $request)
    {
        $data = $request->validated();

        $account = Auth::user()->account;

        $pixKey = PixKey::create([
            'name'       => $data['name'],
            'status'     => $data['status'],
            'account_id' => $account->id
        ]);

        return response()->json([
            'pixKey' => $pixKey
        ], 200);
    }

    public function destroy(Response $response, PixKey $pixKey)
    {
        $pixKey->delete();
        return response()->json(null, 200);
    }
}
