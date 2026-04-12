<?php

namespace App\Http\Controllers;

use App\Models\PolozkaKosika;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::check()) {
            PolozkaKosika::where('pouzivatel_id', Auth::id())->delete();
        }

        session()->forget('cart');
        session()->forget('total');
        return redirect()->route('payment.success');
    }
}
