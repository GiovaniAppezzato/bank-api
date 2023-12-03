<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransferRequest;

class TransferController extends Controller
{
    public function index()
    {
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });
    
        $transfers = Transfer::whereHas('accounts', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();
    
        return response()->json([
            'transfers' => $transfers
        ], 200);
    }

    public function store(StoreTransferRequest $request)
    {
        $data = $request->validated();

        $accountSender = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $accountReceiver = Account::whereHas('user', function($query) use ($data){ //QUESTION: Somehow i feel like "$data->receiver_id" is wrong, huh?
            $query->where('id', $data->receiver_id);
        });

        $accountSender->balance = $accountSender->balance - $data->amount;
        $accountSender->save();

        $accountReceiver->balance = $accountReceiver->balance + $data->amount;
        $accountReceiver->save();

        $transfer = Transfer::create([
            'amount'   => $data->amount,
            'sender_id'   => $accountSender->id,
            'receiver_id' => $data->receiver,
            'amount'   => $data->amount,
            'date'     => now()
        ]);

        return response()->json([
            'status'   => true,
            'transfer' => $transfer
        ], 201);
    }

}
