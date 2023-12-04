<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Report;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\TransactionTypesEnum;
use App\Http\Requests\StoreTransferRequest;

class TransferController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        $transfers = Transfer::whereHas('accounts', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();

        return response()->json([
            'transfers' => $transfers
        ], 200);
    }

    public function store(StoreTransferRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $accountSender = Auth::user()->account;
            $accountReceiver = Account::where('number', $data['number'])->first();

            $accountSender->balance = $accountSender->balance - $data['amount'];
            $accountSender->save();

            $accountReceiver->balance = $accountReceiver->balance + $data['amount'];
            $accountReceiver->save();

            $transfer = Transfer::create([
                'amount'      => $data['amount'],
                'sender_id'   => $accountSender->id,
                'receiver_id' => $accountReceiver->id,
            ]);

            $report = Report::create([
                'amount' => $data['amount'],
                'status' => 'out',
                'transaction_type' => TransactionTypesEnum::TRANSFER,
                'transaction_id' => $transfer->id,
                'account_id' => $accountSender->id,
            ]);

            Report::create([
                'amount' => $data['amount'],
                'status' => 'in',
                'transaction_type' => TransactionTypesEnum::TRANSFER,
                'transaction_id' => $transfer->id,
                'account_id' => $accountReceiver->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'transfer' => $transfer,
                'accountSender' => $accountSender,
                'report' => $report,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

}
