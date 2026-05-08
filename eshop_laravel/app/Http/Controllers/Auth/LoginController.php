<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PolozkaKosika;
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
                $this->mergeSessionCartIntoUserCart($sessionCart, Auth::id());
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
        if (Auth::check()) {
            $request->session()->put('cart', $this->buildSessionCartFromUserCart(Auth::id()));
        }

        Auth::logout();
        $request->session()->regenerateToken();

        return redirect('/');
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

    private function buildSessionCartFromUserCart(int $userId): array
    {
        $dbItems = PolozkaKosika::where('pouzivatel_id', $userId)
            ->with('produkt')
            ->get();

        $cart = [];
        foreach ($dbItems as $item) {
            if (!$item->produkt) {
                continue;
            }

            $cart[$item->produkt_id] = [
                'nazov' => $item->produkt->nazov,
                'quantity' => $item->mnozstvo,
                'cena' => $item->produkt->cena,
                'produkt_id' => $item->produkt_id,
                'image_path' => $item->produkt->image_path,
            ];
        }

        return $cart;
    }
}