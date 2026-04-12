@extends('layouts.app')

@section('title', 'Prehľad produktov | Admin')

@section('content')
<div class="p-3 bg-gray-400 rounded-lg text-center mb-10 font-bold mx-5 mt-6">
    <h1 class="text-xl">Prehľad produktov</h1>
</div>

<main class="flex flex-col lg:flex-row grow">
    <div class="flex flex-col justify-center flex-1">
        <div class="bg-white text-black grid grid-cols-1 justify-items-center items-start h-full mb-10 sm:grid-cols-2 gap-5 px-4 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 xl:gap-x-10">
            @php
                // Simulating some products for the admin review
                $sampleProducts = [
                    ['id' => 1, 'name' => 'Tričko biele', 'price' => 19.99, 'old_price' => 23.50],
                    ['id' => 2, 'name' => 'Čierna mikina', 'price' => 21.99, 'old_price' => 25.00],
                    ['id' => 3, 'name' => 'Rifle', 'price' => 23.47, 'old_price' => 29.90],
                    ['id' => 4, 'name' => 'Vzorované šaty', 'price' => 27.99, 'old_price' => 30.00],
                ];
            @endphp

            @foreach($sampleProducts as $p)
                <div class="flex rounded-2xl mb-3 items-center justify-center bg-[#c2c0c078] hover:brightness-85 active:brightness-85 p-4 w-full">
                    <div class="flex flex-col bg-gray-300 rounded-lg overflow-hidden w-full">
                        <img src="{{ asset('images/product' . $p['id'] . '.png') }}" alt="{{ $p['name'] }}" class="w-full object-contain">
                        <span class="flex h-15 justify-center text-center text-black-500 font-bold text-xl mt-2 wrap-break-word">
                           {{ $p['name'] }}
                        </span>
                        <div class="flex justify-between mt-auto items-center p-2">
                            <div class="flex flex-col">
                                <span class="flex justify-left line-through items-center text-gray-600 text-sm">
                                    {{ number_format($p['old_price'], 2) }} €
                                </span>
                                <span class="flex justify-center items-center text-black-500 text-2xl font-bold">
                                    {{ number_format($p['price'], 2) }} €
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 p-2">
                            <a href="/edit_product" class="bg-blue-500 text-white text-center py-2 rounded-md hover:bg-blue-600 transition">Upraviť</a>
                            <button class="bg-red-500 text-white text-center py-2 rounded-md hover:bg-red-600 transition">Vymazať</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
