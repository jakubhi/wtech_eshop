@extends('layouts.app')

@section('title', 'Admin dashboard | E-Shop')

@section('content')
<main class="flex flex-col flex-1 items-center w-full p-6 mb-10">
    <div class="p-3 w-full bg-gray-400 rounded-lg text-center mb-10 font-bold">
        <h1 class="text-xl">Admin dashboard</h1>
    </div>

    <div class="flex flex-col w-full gap-y-3 text-center max-w-2xl">
        <a href="/admin_products_review" class="py-4 px-6 w-full bg-gray-100 hover:bg-gray-200 rounded-md shadow-sm transition">
            Prehľad a úprava produktov
        </a>

        <a href="/add_product" class="py-4 px-6 w-full bg-gray-100 hover:bg-gray-200 rounded-md shadow-sm transition">
            Pridať nový produkt
        </a>

        <button class="py-4 px-6 w-full bg-gray-100 hover:bg-gray-200 rounded-md shadow-sm transition">
            Štatistiky predaja
        </button>
    </div>
</main>
@endsection
