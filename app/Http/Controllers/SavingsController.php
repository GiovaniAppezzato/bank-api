<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    public function index()
    {
        $savings = Auth::user()->account->savings;

        return response()->json([
            'success' => true,
            'savings' => $savings
        ], 200);
    }
}
