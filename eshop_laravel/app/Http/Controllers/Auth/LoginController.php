<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CartSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(private readonly CartSyncService $cartSyncService) {
    
    }

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

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();
        $this->cartSyncService->mergeCurrentSessionCart((int) Auth::id());

        return $this->postLoginRedirect();
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->session()->put('cart', $this->cartSyncService->buildSessionCartFromUserCart((int) Auth::id()));
        }

        Auth::logout();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function postLoginRedirect()
    {
        return Auth::user()->rola === 'admin'
            ? redirect()->intended('admin_dashboard')
            : redirect()->intended('/');
    }
}