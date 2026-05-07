<?php

namespace App\Http\Controllers;

use App\Models\PolozkaKosika;
use App\Models\Produkt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function continueToContact(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:card,cash,transfer'],
            'card_owner' => ['required_if:payment_method,card', 'nullable', 'regex:/^[\p{L}][\p{L}\s\'-]*$/u', 'max:100'],
            'card_number' => ['required_if:payment_method,card', 'nullable', 'regex:/^[0-9 ]{13,19}$/'],
            'card_expiry' => ['required_if:payment_method,card', 'nullable', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'card_cvv' => ['required_if:payment_method,card', 'nullable', 'regex:/^[0-9]{3,4}$/'],
        ], [
            'payment_method.required' => 'Vyberte spôsob platby.',
            'payment_method.in' => 'Zvolený spôsob platby nie je platný.',
            'card_owner.required_if' => 'Pri platbe kartou je meno na karte povinné.',
            'card_owner.regex' => 'Meno na karte môže obsahovať iba písmená.',
            'card_number.required_if' => 'Pri platbe kartou je číslo karty povinné.',
            'card_number.regex' => 'Číslo karty musí obsahovať 13 až 19 číslic.',
            'card_expiry.required_if' => 'Pri platbe kartou je platnosť karty povinná.',
            'card_expiry.regex' => 'Platnosť musí byť vo formáte MM/RR.',
            'card_cvv.required_if' => 'Pri platbe kartou je CVV povinné.',
            'card_cvv.regex' => 'CVV musí mať 3 alebo 4 číslice.',
        ]);

        session([
            'checkout_payment' => [
                'payment_method' => $validated['payment_method'],
                'card_owner' => $validated['card_owner'] ?? null,
                'card_number' => $validated['card_number'] ?? null,
                'card_expiry' => $validated['card_expiry'] ?? null,
                'card_cvv' => $validated['card_cvv'] ?? null,
            ],
        ]);

        return redirect('/contact_info');
    }

    public function store(Request $request)
    {
        $checkoutPayment = session('checkout_payment', []);

        $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\p{L}][\p{L}\s\'-]*$/u'],
            'last_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\p{L}][\p{L}\s\'-]*$/u'],
            'phone' => ['required', 'regex:/^\+?[0-9 ]{9,15}$/'],
            'email' => ['required', 'email', 'max:120'],
            'city' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[\p{L}][\p{L}\s\'-]*$/u'],
            'zip_code' => ['required', 'regex:/^[0-9]{3}\s?[0-9]{2}$/'],
            'street' => ['required', 'string', 'min:3', 'max:120'],
            'country' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[\p{L}][\p{L}\s\'-]*$/u'],
        ], [
            'phone.regex' => 'Telefónne číslo musí byť v tvare +421 ...',
            'zip_code.regex' => 'PSČ musí byť vo formáte 12345 alebo 123 45.',
            'first_name.regex' => 'Krstné meno môže obsahovať iba písmená.',
            'last_name.regex' => 'Priezvisko môže obsahovať iba písmená.',
            'city.regex' => 'Mesto môže obsahovať iba písmená.',
            'country.regex' => 'Štát môže obsahovať iba písmená.',
        ]);

        if (!isset($checkoutPayment['payment_method'])) {
            return redirect('/delivery')->withErrors([
                'payment_method' => 'Vyberte spôsob platby pred pokračovaním.',
            ]);
        }

        DB::transaction(function () {
            if (Auth::check()) {
                $cartItems = PolozkaKosika::where('pouzivatel_id', Auth::id())->get();

                foreach ($cartItems as $item) {
                    Produkt::where('produkt_id', $item->produkt_id)
                        ->update([
                            'skladom' => DB::raw('GREATEST(skladom - ' . (int) $item->mnozstvo . ', 0)')
                        ]);
                }
            } else {
                $sessionCart = session('cart', []);

                foreach ($sessionCart as $item) {
                    $produktId = (int) ($item['produkt_id'] ?? 0);
                    $quantity = max((int) ($item['quantity'] ?? 0), 0);

                    if ($produktId > 0 && $quantity > 0) {
                        Produkt::where('produkt_id', $produktId)
                            ->update([
                                'skladom' => DB::raw('GREATEST(skladom - ' . $quantity . ', 0)')
                            ]);
                    }
                }
            }
        });

        if (Auth::check()) {
            PolozkaKosika::where('pouzivatel_id', Auth::id())->delete();
        }

        session()->forget('cart');
        session()->forget('total');
        session()->forget('checkout_payment');
        return redirect()->route('payment.success');
    }
}
