<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index() //TODO: Is this all? Like... for real?
    {
        $account = Account::findOrFail(Auth::id());

        return response()->json([
            'number' => true,
            'account' => $account
        ]);
    }
}
