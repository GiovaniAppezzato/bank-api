<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    public function index()
    {
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });
        
        $savings = Saving::whereHas('account', function($query) use ($account){
            $query->where('account_id', $account->id);
        });

        return response()->json([
            'success' => true,
            'savings' => $savings
        ], 200);
    }

    public function store() //QUESTION: Is it better to crate a savings here? Or in UserController?
    {
        
    }
}
