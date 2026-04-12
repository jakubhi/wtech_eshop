@extends('layouts.app')

@section('title', 'Košík | E-Shop')

@section('content')
<main class="flex flex-row flex-1 bg-white">
    <div class="hidden items-center lg:flex md:w-[5%]"></div>
    
    <div class="flex flex-col flex-1 bg-white">
        <nav class="bg-white grid grid-cols-3 py-2 px-15 items-center gap-x-20">
            <div class="flex flex-col font-bold items-center">
                <span>Košík</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 text-white bg-black">1</span>
            </div>
            
            <div class="flex flex-col items-center">
                <span>Doprava</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 bg-[#D9D9D9]">2</span>
            </div>

            <div class="flex flex-col items-center whitespace-nowrap">
                <span>Dodacie údaje</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 bg-[#D9D9D9]">3</span>
            </div>
        </nav>

        <section class="flex flex-col md:flex-row gap-6 mx-5 mt-10">
            <div class="grow flex flex-col md:w-2/3 gap-y-2">
                @forelse($cart as $id => $details)
                <div class="border border-gray-200 rounded-lg p-3 flex flex-row items-center bg-white shadow-sm">
                    <div class="flex flex-row flex-1 items-center">
                        <div class="w-18 h-24 md:w-22 md:h-28 rounded-md bg-gray-100 overflow-hidden flex items-center justify-center shrink-0 border border-gray-100">
                            <img src="{{ $details['image_path'] ?? asset('images/product' . (($id - 1) % 9 + 1) . '.png') }}" alt="{{ $details['nazov'] }}" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col ml-5 sm:ml-7">
                            <div class="text-base sm:text-lg font-bold leading-tight">{{ $details['nazov'] }}</div>
                            <div class="text-green-600 text-xs font-semibold mt-1">Skladom</div>
                        </div>
                    </div>
                    
                    <div class="flex flex-row items-center gap-5 sm:gap-10 pr-3">
                        <div class="text-lg font-bold whitespace-nowrap">{{ number_format($details['cena'], 2) }} €</div>
                        <div class="flex flex-row items-center bg-gray-100 rounded-md border border-gray-300">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-1.5 hover:bg-gray-200 transition">
                                    <img src="{{ asset('images/trash.png') }}" alt="trash" class="w-4 h-4 opacity-50">
                                </button>
                            </form>
                            <span class="px-3.5 text-sm font-bold">{{ $details['quantity'] }}</span>
                            <form action="{{ route('cart.add', $id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="p-1.5 px-3.5 hover:bg-gray-200 transition font-bold text-base">+</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-20 border-2 border-dashed border-gray-300 rounded-xl m-8">
                    <p class="text-xl text-gray-500">Váš košík je prázdny</p>
                    <a href="{{ route('products.index') }}" class="mt-4 text-blue-500 underline">Pokračovať v nákupe</a>
                </div>
                @endforelse
            </div>

            <div class="flex flex-col bg-gray-100 md:w-1/3 md:h-fit md:m-8 pb-6 mt-10 rounded-xl shadow-sm">
                <div class="text-3xl font-bold mt-6 flex justify-center border-b pb-4 mx-4">Zhrnutie</div>
                <div class="text-lg font-semibold mt-4 ml-4">Počet produktov v košíku: {{ $cartCount }}</div>
                <div class="mt-8 ml-4 flex flex-row mb-2 w-full justify-between items-center pr-10">
                    <div class="text-lg font-semibold">Celková suma:</div>
                    <div class="flex text-2xl font-bold text-black">{{ number_format($cartTotal, 2) }} €</div>
                </div>
            </div>
        </section>

        <div class="flex justify-end mt-10 mb-5 px-5">
            <a href="/delivery">
                <button class="border rounded-xl border-gray-200 bg-gray-300 p-3 px-10 hover:bg-gray-400 transition font-bold">
                    Pokračovať
                </button>
            </a>
        </div>
    </div>
    <div class="hidden items-center lg:flex md:w-[5%]"></div>
</main>
@endsection
