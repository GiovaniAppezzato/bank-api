<?php

namespace App\Http\Controllers;

use App\Models\PixKey;
use App\Models\Account;
use App\Models\PixMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePixMovementRequest;

class PixMovementController extends Controller
{
    public function index()
    {
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $pixMovements = PixMovement::whereHas('accounts', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();

        return response()->json([
            'pixMovements' => $pixMovements
        ], 200);
    }

    public function store(StorePixMovementRequest $request)
    {
        $data = $request->validated();

        $accountSender = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $pixKey = PixKey::where('id', $data->pix_key_id); //QUESTION: Grabbing by ID seems ok?

        $accountReceiver = Account::whereHas('pix_keys', function($query) use ($pixKey) {
            $query->where('id', $pixKey->id);
        });

        $accountSender->balance = $accountSender->balance - $data->amount;
        $accountSender->save();

        $accountReceiver->balance = $accountReceiver->balance + $data->amount;
        $accountReceiver->save();

        $pixMovement = PixMovement::create([
            'amount'      => $data->amount,
            'sender_id'   => $accountSender,
            'receiver_id' => $accountReceiver,
            'pix_key_id'  => $pixKey,
        ]);

        return response()->json([
            'status'       => true,
            'pixMovements' => $pixMovement
        ], 201);
    }
}
