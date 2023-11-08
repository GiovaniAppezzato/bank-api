<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $account = Account::findOrFail(Auth::id());

        return response()->json([
            'success' => true,
            'account' => $account
        ], 200);
    }
}
