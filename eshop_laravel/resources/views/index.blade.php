@extends('layouts.app')

@section('title', 'Hlavná stránka | E-shop')

@section('content')
    <main class="flex flex-row grow">
        <div class="justify-center hidden bg-white text-black lg:flex lg:w-[10%] lg:text-2xl lg:text-center lg:items-center">
            Výpredaj až -30%
        </div>
        
        <div class="flex flex-col grow">
            <div class="flex flex-col justify-center">
                <div class="bg-white text-black grid grid-cols-2 gap-2 px-1 p-1 text-sm transition mt-5 sm:grid-cols-3 sm:text-base md:grid-cols-3 md:text-lg lg:grid-cols-3 lg:p-1 xl:grid-cols-4">
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}">
                            <div class="bg-[#393838] text-white border-2 border-black p-2 text-center rounded-full hover:brightness-85 active:brightness-85">
                                {{ $category->nazov }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <hr class="border-t border-gray-200 mt-10 block w-full">

            <div class="flex items-center justify-center bg-white text-black">
                <h2 class="font-bold uppercase text-white text-xl py-4">
                    Odporúčame
                </h2>
            </div>

            <div class="bg-white text-black grid grid-cols-1 justify-items-center items-start h-full mb-10 sm:grid-cols-2 gap-5 px-4 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 xl:gap-x-10">
                @foreach($recommended as $product)
                    <div class="bg-[#c2c0c078] rounded-2xl mb-3 flex items-center justify-center hover:brightness-85 active:brightness-85">
                        <div class="flex flex-col bg-gray-300 rounded-lg overflow-hidden">
                            <a href="{{ route('products.show', $product->produkt_id) }}">
                                <img src="{{ $product->image_path }}" alt="{{ $product->nazov }}">
                            </a>
                            <span class="flex h-20 justify-center text-center text-black-500 font-bold text-2xl mb-2 mt-2 wrap-break-word">
                                {{ $product->nazov }}
                            </span>
                            <div class="flex justify-between mt-auto items-center">
                                <div class="flex flex-col">
                                    <span class="flex justify-left line-through items-center flex-1 text-gray-600 text-xl rounded-full ml-2 mr-2">
                                        {{ number_format($product->cena * 1.2, 2) }} €
                                    </span>
                                    <span class="flex justify-center flex-1 items-center text-black-500 text-3xl rounded-full mr-2">
                                        {{ number_format($product->cena, 2) }} €
                                    </span>
                                </div>
                                <form action="{{ route('cart.add', $product->produkt_id) }}" method="POST" class="mr-3">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-gray-300 hover:bg-gray-400 transition">
                                        <img src="{{ asset('images/cart.png') }}" class="w-12 object-contain">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <nav class="flex justify-center gap-x-1 mt-10 mb-5">
                {{ $recommended instanceof \Illuminate\Pagination\LengthAwarePaginator ? $recommended->links('vendor.pagination.eshop') : '' }}
            </nav>
        </div>

        <div class="bg-white text-black hidden items-center lg:flex md:w-[5%]"></div>
    </main>
@endsection
