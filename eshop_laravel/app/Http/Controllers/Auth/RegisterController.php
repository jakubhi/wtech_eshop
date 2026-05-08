<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PolozkaKosika;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('pages.register_page');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'heslo' => ['required', 'string', 'min:8'],
        ], [
            'login.required' => 'Login je povinný.',
            'login.unique' => 'Tento login sa už používa.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadajte platný email.',
            'email.unique' => 'Tento email je už registrovaný.',
            'heslo.required' => 'Heslo je povinné.',
            'heslo.min' => 'Heslo musí mať aspoň :min znakov.',
        ]);

        $user = User::create([
            'login' => $validated['login'],
            'email' => $validated['email'],
            'heslo' => Hash::make($validated['heslo']),
            'rola' => ($request->query('type') === 'admin') ? 'admin' : 'zakaznik',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart)) {
            $this->mergeSessionCartIntoUserCart($sessionCart, $user->pouzivatel_id);
            session()->forget('cart');
        }

        return $user->rola === 'admin'
            ? redirect()->intended('admin_dashboard')
            : redirect()->intended('/');
    }

    private function mergeSessionCartIntoUserCart(array $sessionCart, int $userId): void
    {
        foreach ($sessionCart as $productId => $details) {
            $quantity = max((int) ($details['quantity'] ?? 0), 0);
            if ($quantity === 0) {
                continue;
            }

            $cartItem = PolozkaKosika::where('pouzivatel_id', $userId)
                ->where('produkt_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->mnozstvo += $quantity;
                $cartItem->save();
                continue;
            }

            PolozkaKosika::create([
                'pouzivatel_id' => $userId,
                'produkt_id' => $productId,
                'mnozstvo' => $quantity,
            ]);
        }
    }
}
