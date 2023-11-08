<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsMovementsController extends Controller
{
    public function index()
    {
        $savings = Savings::findOrFail(Auth::id()); //QUESTION: Savings or Account?

        $savingsMovements = SavingsMovements::whereHas('savings', function ($query) use ($savings){
            $query->where('savings_id', $savings->id);
        })->get();
    }

    //TODO: Store function
}
