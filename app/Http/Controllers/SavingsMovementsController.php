<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsMovementsController extends Controller
{
    public function index()
    {
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });
        
        $savings = Saving::whereHas('account', function($query) use ($account){
            $query->where('account_id', $account->id);
        });

        $savingsMovements = SavingsMovements::whereHas('savings', function ($query) use ($savings){
            $query->where('savings_id', $savings->id);
        })->get();

        return response()->json([
            'success' => true,
            'savings' => $savingsMovements
        ], 200);
    }

    public function store(StoreSavingsMovementsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });
        
        $savings = Savings::whereHas('account', function($query) use ($account){
            $query->where('account_id', $account->id);
        });

        if($data->type === 'Deposit'){
            $updatedValue = $savings->balance + $data->amount;
            $savings->balance = $updateValue;
            $savings->save();
        }elseif($data->type === 'Withdraw'){
            $updatedValue = $savings->balance - $data->amount;
            $savings->balance = $updatedValue;
            $savings->save();
        }
        
        $savingsMovements = Savings::create([
            'amount' => $data->amount,
            'type'   => $data->type,
            'savings_id' => $savings->id,
        ]);
        
        return response()->json([
            'savingsMovements' => $savingsMovements
        ], 201);
    }
}
