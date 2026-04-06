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

            #$user = Auth::user();
            #if ($user->rola === 'admin') {
            #    return redirect()->intended('/admin_dashboard');
            #}

            #return redirect()->intended('/');

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

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}