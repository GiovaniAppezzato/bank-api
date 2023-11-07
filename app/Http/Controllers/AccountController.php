<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index() //TODO: Is this all? Like... for real?
    {
        $account = Account::findOrFail(Auth::id());

        return response()->json([
            'success' => true,
            'account' => $account
        ], 200);
    }
}
