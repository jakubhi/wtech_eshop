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
            'delivery_method' => ['required', 'in:kurier,posta,osobny_odber'],
            'payment_method' => ['required', 'in:card,cash,transfer'],
            'card_owner' => ['required_if:payment_method,card', 'nullable', 'regex:/^[\p{L}][\p{L}\s\'-]*$/u', 'max:100'],
            'card_number' => ['required_if:payment_method,card', 'nullable', 'regex:/^[0-9 ]{13,19}$/'],
            'card_expiry' => ['required_if:payment_method,card', 'nullable', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'card_cvv' => ['required_if:payment_method,card', 'nullable', 'regex:/^[0-9]{3,4}$/'],
        ], [
            'delivery_method.required' => 'Vyberte spôsob dopravy.',
            'delivery_method.in' => 'Zvolený spôsob dopravy nie je platný.',
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
                'delivery_method' => $validated['delivery_method'],
                'payment_method' => $validated['payment_method'],
                'card_owner' => $this->nullableValidatedValue($validated, 'card_owner'),
                'card_number' => $this->nullableValidatedValue($validated, 'card_number'),
                'card_expiry' => $this->nullableValidatedValue($validated, 'card_expiry'),
                'card_cvv' => $this->nullableValidatedValue($validated, 'card_cvv'),
            ],
        ]);

        return redirect('/contact_info');
    }

    public function store(Request $request)
    {
        $checkoutPayment = session('checkout_payment', []);

        $validatedContact = $request->validate([
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

        if (!isset($checkoutPayment['delivery_method'])) {
            return redirect('/delivery')->withErrors([
                'delivery_method' => 'Vyberte spôsob dopravy pred pokračovaním.',
            ]);
        }

        $orderUserId = $this->resolveOrderUserId();
        if ($orderUserId < 1) {
            return redirect('/login')->withErrors([
                'auth' => 'Pre dokončenie objednávky sa prihláste alebo vytvorte účet.',
            ]);
        }

        $normalizedCartItems = $this->resolveNormalizedCartItems();
        if (count($normalizedCartItems) < 1) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => 'Košík je prázdny.',
            ]);
        }

        DB::transaction(function () use ($validatedContact, $checkoutPayment, $normalizedCartItems, $orderUserId) {
            $deliveryDataId = DB::table('Dodacie_udaje')->insertGetId([
                'meno' => $validatedContact['first_name'],
                'priezvisko' => $validatedContact['last_name'],
                'telefon' => $validatedContact['phone'],
                'email' => $validatedContact['email'],
                'mesto' => $validatedContact['city'],
                'ulica' => $validatedContact['street'],
                'psc' => $validatedContact['zip_code'],
                'stat' => $validatedContact['country'],
                'sposob_dorucenia' => $checkoutPayment['delivery_method'],
            ], 'dodacie_udaje_id');

            $orderId = DB::table('Objednavka')->insertGetId([
                'pouzivatel_id' => $orderUserId,
                'dodacie_udaje_id' => $deliveryDataId,
                'stav' => 'nova',
            ], 'objednavka_id');

            $paymentTotal = 0.0;
            foreach ($normalizedCartItems as $item) {
                DB::table('Polozka_objednavky')->insert([
                    'objednavka_id' => $orderId,
                    'produkt_id' => $item['produkt_id'],
                ]);

                $paymentTotal += $item['cena'] * $item['mnozstvo'];

                Produkt::where('produkt_id', $item['produkt_id'])
                    ->update([
                        'skladom' => DB::raw('GREATEST(skladom - ' . $item['mnozstvo'] . ', 0)'),
                    ]);
            }

            DB::table('Platba')->insert([
                'objednavka_id' => $orderId,
                'suma' => $paymentTotal,
                'sposob_platby' => $this->mapPaymentMethodToEnum($checkoutPayment['payment_method']),
            ]);

            if (Auth::check()) {
                PolozkaKosika::where('pouzivatel_id', Auth::id())->delete();
            }
        });

        session()->forget('cart');
        session()->forget('total');
        session()->forget('checkout_payment');
        return redirect()->route('payment.success');
    }

    private function resolveNormalizedCartItems(): array
    {
        $items = [];

        if (Auth::check()) {
            $dbItems = PolozkaKosika::where('pouzivatel_id', Auth::id())
                ->with('produkt')
                ->get();

            foreach ($dbItems as $item) {
                if (!$item->produkt) {
                    continue;
                }

                $productId = (int) $item->produkt_id;
                $quantity = max((int) $item->mnozstvo, 0);
                if ($productId < 1 || $quantity < 1) {
                    continue;
                }

                if (isset($items[$productId])) {
                    $items[$productId]['mnozstvo'] += $quantity;
                } else {
                    $items[$productId] = [
                        'produkt_id' => $productId,
                        'mnozstvo' => $quantity,
                        'cena' => (float) $item->produkt->final_price,
                    ];
                }
            }
        } else {
            $sessionCart = session('cart', []);

            foreach ($sessionCart as $item) {
                if (isset($item['produkt_id'])) {
                    $productId = (int) $item['produkt_id'];
                } else {
                    $productId = 0;
                }

                if (isset($item['quantity'])) {
                    $quantity = max((int) $item['quantity'], 0);
                } else {
                    $quantity = 0;
                }

                if ($productId < 1 || $quantity < 1) {
                    continue;
                }

                $product = Produkt::find($productId);
                if (!$product) {
                    continue;
                }

                if (isset($items[$productId])) {
                    $items[$productId]['mnozstvo'] += $quantity;
                } else {
                    $items[$productId] = [
                        'produkt_id' => $productId,
                        'mnozstvo' => $quantity,
                        'cena' => (float) $product->final_price,
                    ];
                }
            }
        }

        return array_values($items);
    }

    private function mapPaymentMethodToEnum(string $paymentMethod): string
    {
        if ($paymentMethod === 'card') {
            return 'karta';
        }

        if ($paymentMethod === 'cash') {
            return 'dobierka';
        }

        return 'prevod';
    }

    private function resolveOrderUserId(): int
    {
        if (Auth::check()) {
            return (int) Auth::id();
        }

        $fallbackUserId = DB::table('Pouzivatel')->orderBy('pouzivatel_id', 'asc')->value('pouzivatel_id');
        if (is_numeric($fallbackUserId)) {
            return (int) $fallbackUserId;
        }

        return 0;
    }

    private function nullableValidatedValue(array $validated, string $key): mixed
    {
        if (isset($validated[$key])) {
            return $validated[$key];
        }

        return null;
    }
}
