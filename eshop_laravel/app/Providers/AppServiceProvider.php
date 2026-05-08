<?php

namespace App\Providers;

use App\Models\PolozkaKosika;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view): void {
            [$total, $count] = $this->resolveCartSummary();

            $view->with([
                'cartTotal' => $total,
                'cartCount' => $count,
            ]);
        });
    }

    private function resolveCartSummary(): array
    {
        if (auth()->check()) {
            return $this->summaryFromDatabaseCart((int) auth()->id());
        }

        return $this->summaryFromSessionCart(session()->get('cart', []));
    }

    private function summaryFromDatabaseCart(int $userId): array
    {
        $total = 0.0;
        $count = 0;

        $cartItems = PolozkaKosika::where('pouzivatel_id', $userId)
            ->with('produkt')
            ->get();

        foreach ($cartItems as $item) {
            if (!$item->produkt) {
                continue;
            }

            $total += $item->produkt->final_price * $item->mnozstvo;
            $count += $item->mnozstvo;
        }

        return [$total, $count];
    }

    private function summaryFromSessionCart(array $cart): array
    {
        $total = 0.0;
        $count = 0;

        foreach ($cart as $item) {
            $total += ((float) ($item['cena'] ?? 0)) * ((int) ($item['quantity'] ?? 0));
            $count += (int) ($item['quantity'] ?? 0);
        }

        return [$total, $count];
    }
}
