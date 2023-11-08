<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\PixMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePixMovementRequest;

class PixMovementController extends Controller
{
    public function index()
    {
        $account = Account::findOrFail(Auth::id());

        $pixMovements = PixMovement::whereHas('accounts', function ($query) use ($account){
            $query->where('account_id', $account->id);
        })->get();

        return response()->json([
            'pixMovements' => $pixMovements
        ], 200);
    }

    public function store(StorePixMovementRequest $request)
    {
        $data = $request->validated();

        $account = Account::findOrFail(Auth::id());

        $pixMovement = PixMovement::create([
            'amount'     => $data->amount,
            'account_id' => $account->id,
            'pix_id'     => $data->pix_id, //QUESTION: Is this needed?
        ]);
    }
}
