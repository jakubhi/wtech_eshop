<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = \App\Models\Kategoria::all();
    $recommended = \App\Models\Produkt::inRandomOrder()->take(10)->get();
    return view('index', compact('categories', 'recommended'));
});

Route::get('/add_product', function () {
    return view('pages.add_new_product');
});

Route::get('/admin_dashboard', function () {
    return view('pages.admin_dashboard');
});

Route::get('/edit_product', function () {
    return view('pages.edit_product');
});

Route::get('/admin_products_review', function () {
    return view('pages.admin_products_review');
});

Route::get('/contact_info', function () {
    return view('pages.contact_info');
});

Route::get('/delivery', function () {
    return view('pages.delivery');
});

Route::get('/filtering_page', function () {
    return view('pages.filtering_page');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/ordered_page', function () {
    return view('pages.ordered_page');
});

Route::get('/payment', function () {
    return view('pages.platba_page');
})->name('payment.success');

Route::post('/order/process', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.process');

Route::get('/product_category', [ProductController::class, 'index'])->name('products.index');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/product_detail/{id}', [ProductController::class, 'show'])->name('products.show');