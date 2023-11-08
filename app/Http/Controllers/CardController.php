<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index() //TODO: Need to be completed
    {
        $account = Account::findOrFail(Auth::id());

        return response()->json([
            'number' => true,
            'account' => $account
        ]);
    }
}
