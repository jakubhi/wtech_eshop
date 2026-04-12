@extends('layouts.app')

@section('title', 'Produkty | E-Shop')

@section('content')
<main class="flex flex-col lg:flex-row grow">
    <div class="flex flex-col grow justify-center items-center py-20">
        <h1 class="text-2xl font-bold mb-4">Filtrovanie produktov</h1>
        <p class="text-gray-600">Stránka pre filtrovanie produktov bola nahradená dynamickou verziou.</p>
        <a href="{{ route('products.index') }}" class="mt-6 border rounded-xl border-gray-200 bg-gray-300 p-3 px-6 hover:bg-gray-400 transition">
            Prejsť na zoznam produktov
        </a>
    </div>
</main>
@endsection
