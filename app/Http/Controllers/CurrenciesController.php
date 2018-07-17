<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendRateChangedEmail;
use App\User;
use App\Entity\Currency;
use Illuminate\Support\Facades\Auth;

class CurrenciesController extends Controller
{
    public function updateRate(Request $request)
    {

    	if (!Auth::user()->getAttribute('is_admin')) 
    	{
           return redirect('/');
       	}

        $currency = Currency::find($request->id);
        $oldRate = $currency->rate;
        $currency->rate = $request->input('rate');
        $currency->save();

        $users = User::where('is_admin', false)->get();

        foreach ($users as $user) {
            SendRateChangedEmail::dispatch($user, $currency, $oldRate)->onQueue('notification');
        }

        return response()->json($currency, 200);
    }
}
