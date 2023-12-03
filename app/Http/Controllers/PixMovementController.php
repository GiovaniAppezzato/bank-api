<?php

namespace App\Http\Controllers;

use App\Models\PixKey;
use App\Models\PixMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePixMovementRequest;

class PixMovementController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        $pixMovements = PixMovement::whereHas('accounts', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();

        return response()->json([
            'pixMovements' => $pixMovements
        ], 200);
    }

    public function store(StorePixMovementRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $accountSender = Auth::user()->account;

            $pixKey = PixKey::with('account')->where('name', $data['pix_key'])->first();
            $accountReceiver = $pixKey->account;

            $accountSender->balance = $accountSender->balance - $data['amount'];
            $accountSender->save();

            $accountReceiver->balance = $accountReceiver->balance + $data['amount'];
            $accountReceiver->save();

            $pixMovement = PixMovement::create([
                'amount'      => $data['amount'],
                'sender_id'   => $accountSender->id,
                'receiver_id' => $accountReceiver->id,
                'pix_key_id'  => $pixKey->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'pixMovement' => $pixMovement,
                'accountSender' => $accountSender,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getAccountByPixKey($pixKey)
    {
        $pixKey = PixKey::with('account.user')->where('name', $pixKey)->first();

        $account = $pixKey ? $pixKey->account : null;

        return response()->json([
            'account' => $account
        ], 200);
    }
}
