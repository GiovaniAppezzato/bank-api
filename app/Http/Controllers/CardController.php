<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCardRequest;

class CardController extends Controller
{
    public function index() //TODO: Need to be completed
    {
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        // $account = Account::findOrFail(Auth::id());
        return response()->json([
            'number' => true,
            'account' => $account
        ]);
    }

    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();
        
        $account = Account::whereHas('user', function($query){
            $query->where('id', Auth::id());
        });

        $card = Card::create([
            'number'          => $data->number,
            'password'        => $data->password,
            'credit_limit'    => $data->credit_limit,
            'experation_date' => $data->experation_date,
            'is_blocked'      => $data->is_blocked,
            'account_id'      => $account->id,
        ]);

        return response()->json([
            'success' => true,
            'card' => $card
        ], 201);
    }

    public function destroy(Card $card)
    {
        $card->update([
            'is_blocked' => true,
        ]);

        return response()->json(['message' => 'The credit card has been blocked'], 201);
    }
}
