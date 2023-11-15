<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index() //TODO: Need to be completed
    {
        $user = Auth::user();
        $account = $user->account;

        // $account = Account::findOrFail(Auth::id());
        return response()->json([
            'number' => true,
            'account' => $account
        ]);
    }

    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $account = $user->account;

        $card = Card::create(['account_id' => $account->id]);

        return response()->json([
            'success' => true,
            'card' => $card
        ], 201);
    }

    public function destroy(Card $card)
    {
        $card->destroy();

        return response()->json(['message' => 'The credit card has been deleted'], 200);
    }
}
