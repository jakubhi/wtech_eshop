<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $total = 0;
            $count = 0;
            if (auth()->check()) {
                $cartItems = \App\Models\PolozkaKosika::where('pouzivatel_id', auth()->id())
                    ->with('produkt')
                    ->get();
                foreach ($cartItems as $item) {
                    $total += $item->produkt->cena * $item->mnozstvo;
                    $count += $item->mnozstvo;
                }
            } else {
                $cart = session()->get('cart', []);
                foreach ($cart as $item) {
                    $total += $item['cena'] * $item['quantity'];
                    $count += $item['quantity'];
                }
            }
            $view->with('cartTotal', $total);
            $view->with('cartCount', $count);
        });
    }
}
