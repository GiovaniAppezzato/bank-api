<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransferRequest;

class TransferController extends Controller
{
    public function store(StoreTransferRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $account = Account::findOrFail(Auth::id());

        $transfer = Transfer::create([
            'sender'   => $account->id,
            'receiver' => $data->receiver,
            'amount'   => $data->amount,
            'date'     => now()
        ]);

        //Just a sketch
        if($transfer->status === 'out'){
            $loss = $account->balance - $data->amount;

            $account = Account::update([
                'balance' => $loss
            ]);
        }else{
            $earn = $account->balance + $data->amount;

            $account = Account::update([
                'balance' => $earn
            ]);
        }

        
        return response()->json([
            'transfer' => $transfer
        ], 201);
    }

    public function index()
    {
        $account = Account::findOrFail(Auth::id());

        $transfers = Transfer::whereHas('accounts', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();

        return response()->json([
            'transfers' => $transfers
        ], 200);
    }
}
