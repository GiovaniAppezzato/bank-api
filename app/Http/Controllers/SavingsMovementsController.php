<?php

namespace App\Http\Controllers;

use App\Models\Savings;
use App\Models\SavingsMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSavingsMovementsRequest;

class SavingsMovementsController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;
        $savings = Savings::where('account_id', $account->id)->first();

        $savingsMovements = SavingsMovement::where('savings_id', $savings->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'savingsMovements' => $savingsMovements
        ], 200);
    }

    public function store(StoreSavingsMovementsRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $account = Auth::user()->account;
            $savings = Savings::where('account_id', $account->id)->first();

            if($data['type'] === 'Deposit') {
                $savingsBalance = $savings->balance + $data['amount'];
                $savings->balance = $savingsBalance;
                $savings->save();

                $accountBalance = $account->balance - $data['amount'];
                $account->balance = $accountBalance;
                $account->save();
            } else {
                $savingsBalance = $savings->balance - $data['amount'];
                $savings->balance = $savingsBalance;
                $savings->save();

                $accountBalance = $account->balance + $data['amount'];
                $account->balance = $accountBalance;
                $account->save();
            }

            $savingsMovements = SavingsMovement::create([
                'amount' => $data['amount'],
                'type'   => $data['type'],
                'savings_id' => $savings->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'savingsMovement' => $savingsMovements,
                'savings' => $savings,
                'account' => $account
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
