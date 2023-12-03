<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLoanRequest;

class LoanController extends Controller
{
    public function index()
    {
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $loans = Loan::whereHas('account', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();

        return response()->json([
            'loans' => $loans
        ], 200);
    }

    public function store(StoreLoanRequest $request)
    {
        $data = $request->validated();

        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $loan = Loan::create([
            'amount'     => $data->amount,
            'account_id' => $account->id
        ]);

        return response()->json([
            'status'   => true,
            'transfer' => $loan
        ], 201);
    }
}
