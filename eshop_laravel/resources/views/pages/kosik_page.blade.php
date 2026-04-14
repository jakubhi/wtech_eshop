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
            <div class="grow flex flex-col md:w-2/3 gap-y-4">
                @forelse($cart as $id => $details)
                <div class="border border-gray-200 rounded-lg p-4 flex flex-row items-start bg-white shadow-md hover:shadow-lg transition">
                    <div class="flex flex-row flex-1 items-start">
                        <div class="w-16 h-20 rounded-md bg-gray-50 overflow-hidden flex items-center justify-center shrink-0 border border-gray-100">
                            <img src="{{ $details['image_path'] ?? asset('images/product' . (($id - 1) % 9 + 1) . '.png') }}" alt="{{ $details['nazov'] }}" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col ml-12 flex-1 pt-1">
                            <div class="text-xl sm:text-2xl font-bold leading-tight text-gray-900">{{ $details['nazov'] }}</div>
                            <div class="text-green-600 text-sm font-semibold mt-1">
                                Skladom
                            </div>
                            <div class="mt-2 text-xl font-bold text-gray-900">
                                {{ number_format($details['cena'], 2) }} €
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-8 pr-2">
                        <div class="flex flex-col items-center gap-2">
                            <form action="{{ route('cart.update', $id) }}" method="POST" id="form_{{ $id }}" class="flex flex-row items-center bg-gray-50 rounded-xl border border-gray-300 shadow-sm overflow-hidden">
                                @csrf
                                <button type="button" onclick="decrementCartQuantity({{ $id }})" class="w-10 h-10 flex items-center justify-center hover:bg-gray-200 transition border-r border-gray-300">
                                    <img src="{{ asset('images/minus.png') }}" alt="minus" class="w-3">
                                </button>
                                <input type="number" id="quantity_input_{{ $id }}" name="quantity" value="{{ $details['quantity'] }}" min="1" onchange="this.form.submit()" class="w-16 text-center bg-transparent border-none focus:ring-0 text-lg font-bold text-gray-800 p-0 m-0">
                                <button type="button" onclick="incrementCartQuantity({{ $id }})" class="w-10 h-10 flex items-center justify-center hover:bg-gray-200 transition border-l border-gray-300">
                                    <img src="{{ asset('images/plus_symbol.png') }}" alt="plus" class="w-3">
                                </button>
                            </form>

                            <form action="{{ route('cart.delete', $id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="group flex items-center gap-2 text-red-500 hover:text-red-700 transition text-xs font-bold uppercase tracking-wider p-1 mt-1">
                                    <img src="{{ asset('images/bin.png') }}" alt="" class="w-4 h-4 opacity-70 group-hover:opacity-100">
                                    Odstrániť
                                </button>
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

        <script>
            function incrementCartQuantity(id) {
                const input = document.getElementById('quantity_input_' + id);
                input.value = parseInt(input.value) + 1;
                document.getElementById('form_' + id).submit();
            }
            function decrementCartQuantity(id) {
                const input = document.getElementById('quantity_input_' + id);
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    document.getElementById('form_' + id).submit();
                }
            }
        </script>

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
