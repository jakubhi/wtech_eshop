<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
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

Route::get('/cart', function () {
    return view('pages.kosik_page');
});

Route::get('/login', function () {
    return view('pages.login_page');
})->name('login');

Route::get('/ordered_page', function () {
    return view('pages.ordered_page');
});

Route::get('/payment', function () {
    return view('pages.platba_page');
});

Route::get('/product_category', function () {
    return view('pages.product_category_page');
});

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/product_detail', function () {
    return view('pages.product_page');
});
