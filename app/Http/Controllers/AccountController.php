<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        return response()->json([
            'success' => true,
            'account' => $account
        ], 200);
    }

    public function getReports()
    {
        $account = Auth::user()->account;

        $reports = $account->reports()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'reports' => $reports
        ], 200);
    }
}
