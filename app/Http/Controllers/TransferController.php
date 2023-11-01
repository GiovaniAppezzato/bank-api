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

        $transfer = Transfer::create([
            'sender'   => $user->id,
            'receiver' => $data->receiver,
            'amount'   => $data->amount,
            'date'     => now()
        ]);

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

    //TODO: Delete a transaction?
}
