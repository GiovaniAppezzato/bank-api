<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLoanRequest;

class LoanController extends Controller
{
    public function store(StoreLoanRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $account = Auth::user()->account;

            $loan = Loan::create([
                'amount'     => $data['amount'],
                'account_id' => $account->id
            ]);

            $account->balance = $account->balance + $loan->amount;
            $account->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'loan' => $loan,
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
