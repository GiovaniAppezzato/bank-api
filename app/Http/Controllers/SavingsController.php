<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsController extends Controller
{
    public function index()
    {
        $savings = Saving::where('account_id', Account::findOrFail(Auth::id()));

        return response()->json([
            'success' => true,
            'savings' => $savings
        ], 200);
    }

}
