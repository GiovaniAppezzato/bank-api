<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCardRequest;

class CardController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;

        $cards = $account->cards()
            ->where('is_blocked', false)
            ->get();

        return response()->json([
            'cards' => $cards
        ]);
    }

    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();

        $account = Auth::user()->account;

        $randomNumber = mt_rand(1000, 9999);
        $randomNumber .= mt_rand(1000, 9999);
        $randomNumber .= mt_rand(1000, 9999);
        $randomNumber .= mt_rand(1000, 9999);

        $expirationDate = Carbon::now()->addYears(10)->toDateString();

        $card = Card::create([
            'number'          => $randomNumber,
            'password'        => bcrypt($data['password']),
            'credit_limit'    => $data['credit_limit'],
            'expiration_date' => $expirationDate,
            'account_id'      => $account->id,
        ]);

        return response()->json([
            'success' => true,
            'card' => $card
        ], 201);
    }

    public function destroy(Card $card)
    {
        $card->is_blocked = true;
        $card->save();

        return response()->json(null, 200);
    }
}
