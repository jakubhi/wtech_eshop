<?php

namespace App\Http\Controllers;

use App\Models\Produkt;
use App\Models\PolozkaKosika;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart()
    {
        if (Auth::check()) {
            $dbItems = PolozkaKosika::where('pouzivatel_id', Auth::id())
                ->with('produkt')
                ->get();
            
            $cart = [];
            foreach ($dbItems as $item) {
                $cart[$item->produkt_id] = [
                    "nazov" => $item->produkt->nazov,
                    "quantity" => $item->mnozstvo,
                    "cena" => $item->produkt->cena,
                    "produkt_id" => $item->produkt_id,
                    "image_path" => $item->produkt->image_path
                ];
            }
            return $cart;
        }
        
        return session()->get('cart', []);
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['cena'] * $item['quantity'];
        }
        return $total;
    }

    public function index()
    {
        $cart = $this->getCart();
        $total = $this->calculateTotal($cart);
        session()->put('total', $total);
        return view('pages.kosik_page', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Produkt::findOrFail($id);
        $quantity = max((int) $request->input('quantity', 1), 1);

        if (Auth::check()) {
            $cartItem = PolozkaKosika::where('pouzivatel_id', Auth::id())
                ->where('produkt_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->mnozstvo += $quantity;
                $cartItem->save();
            } else {
                PolozkaKosika::create([
                    'pouzivatel_id' => Auth::id(),
                    'produkt_id' => $id,
                    'mnozstvo' => $quantity
                ]);
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    "nazov" => $product->nazov,
                    "quantity" => $quantity,
                    "cena" => $product->cena,
                    "produkt_id" => $product->produkt_id,
                    "image_path" => $product->image_path
                ];
            }
            session()->put('cart', $cart);
        }

        $total = $this->calculateTotal($this->getCart());
        session()->put('total', $total);

        return redirect()->back()->with('success', 'Produkt bol pridaný do košíka!');
    }

    public function remove($id)
    {
        if (Auth::check()) {
            $cartItem = PolozkaKosika::where('pouzivatel_id', Auth::id())
                ->where('produkt_id', $id)
                ->first();

            if ($cartItem) {
                if ($cartItem->mnozstvo > 1) {
                    $cartItem->mnozstvo -= 1;
                    $cartItem->save();
                } else {
                    $cartItem->delete();
                }
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                if ($cart[$id]['quantity'] > 1) {
                    $cart[$id]['quantity'] -= 1;
                } else {
                    unset($cart[$id]);
                }
                session()->put('cart', $cart);
            }
        }
        
        $total = $this->calculateTotal($this->getCart());
        session()->put('total', $total);

        return redirect()->back()->with('success', 'Položka bola upravená!');
    }

    public function delete($id)
    {
        if (Auth::check()) {
            PolozkaKosika::where('pouzivatel_id', Auth::id())
                ->where('produkt_id', $id)
                ->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        $total = $this->calculateTotal($this->getCart());
        session()->put('total', $total);

        return redirect()->back()->with('success', 'Položka bola odstránená z košíka!');
    }

    public function update(Request $request, $id)
    {
        $quantity = max((int) $request->quantity, 1);

        if (Auth::check()) {
            PolozkaKosika::where('pouzivatel_id', Auth::id())
                ->where('produkt_id', $id)
                ->update(['mnozstvo' => $quantity]);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }

        $total = $this->calculateTotal($this->getCart());
        session()->put('total', $total);

        return redirect()->back()->with('success', 'Košík bol aktualizovaný!');
    }
}
