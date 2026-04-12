<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.login_page');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                $user = Auth::user();
                foreach ($sessionCart as $productId => $details) {
                    $cartItem = \App\Models\PolozkaKosika::where('pouzivatel_id', $user->pouzivatel_id)
                        ->where('produkt_id', $productId)
                        ->first();

                    if ($cartItem) {
                        $cartItem->mnozstvo += $details['quantity'];
                        $cartItem->save();
                    } else {
                        \App\Models\PolozkaKosika::create([
                            'pouzivatel_id' => $user->pouzivatel_id,
                            'produkt_id' => $productId,
                            'mnozstvo' => $details['quantity']
                        ]);
                    }
                }
                session()->forget('cart');
            }

            if (Auth::user()->rola === 'admin') {
                return redirect()->intended('admin_dashboard');
            } 
            else {
                return redirect()->intended('/'); 
            }


            
        }

        throw ValidationException::withMessages([
            'login' => [__('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}