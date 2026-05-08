<?php

namespace App\Services;

use App\Models\PolozkaKosika;

class CartSyncService
{
    public function mergeSessionCartIntoUserCart(array $sessionCart, int $userId): void
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

    public function buildSessionCartFromUserCart(int $userId): array
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

    public function mergeCurrentSessionCart(int $userId): void
    {
        $sessionCart = session()->get('cart', []);
        if (empty($sessionCart)) {
            return;
        }

        $this->mergeSessionCartIntoUserCart($sessionCart, $userId);
        session()->forget('cart');
    }
}
