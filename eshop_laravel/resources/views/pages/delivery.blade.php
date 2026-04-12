@extends('layouts.app')

@section('title', 'Výber dopravy | E-Shop')

@section('content')
<main class="flex flex-row flex-1 bg-white">
    <div class="hidden items-center lg:flex md:w-[5%]"></div>
    
    <div class="flex flex-col flex-1 bg-white">
        <nav class="bg-white grid grid-cols-3 py-2 px-15 items-center gap-x-20">
            <div class="flex flex-col items-center">
                <span>Košík</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 bg-[#D9D9D9]">1</span>
            </div>
            
            <div class="flex flex-col font-bold items-center">
                <span>Doprava</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 text-white bg-black">2</span>
            </div>

            <div class="flex flex-col items-center whitespace-nowrap">
                <span>Dodacie údaje</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 bg-[#D9D9D9]">3</span>
            </div>
        </nav>

        <section class="flex flex-col md:flex-row mr-5 ml-5">
            <div class="flex flex-col md:flex-row w-full mt-10">
                <div class="flex flex-col md:w-7/12 px-5">
                    <span class="font-bold text-xl py-5">Zvoľte spôsob doručenia</span>
                    
                    <div class="flex flex-col gap-y-3">
                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="doprava">
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300"></span>
                            <span class="text-lg ml-5">Doručiť do Eshop boxu</span>
                        </label>

                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="doprava">
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300"></span>
                            <span class="text-lg ml-5">Doručenie domov</span>
                        </label>

                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="doprava">
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300"></span>
                            <span class="text-lg ml-5">Osobné vyzdvihnutie na pobočke</span>
                        </label>
                    </div>

                    <hr class="mt-10 mb-5 border-[#D9D9D9]">
                    
                    <div class="flex flex-col gap-y-2">
                        <span class="font-bold text-xl py-5">Zvoľte spôsob platby</span>
                        
                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="platba">
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300"></span>
                            <span class="text-lg ml-5">Kartou online</span>
                        </label>
                        
                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="platba">
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300"></span>
                            <span class="text-lg ml-5">Platba pri prevzatí</span>
                        </label>

                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="platba">
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300"></span>
                            <span class="text-lg ml-5">Platba prevodom na účet</span>
                        </label>
                    </div>                        
                </div>

                <div class="flex flex-col bg-gray-100 md:w-1/3 md:h-fit md:m-8 pb-6 mt-10 rounded-xl shadow-sm">
                    <div class="text-3xl font-bold mt-6 flex justify-center border-b pb-4 mx-4">Zhrnutie</div>
                    <div class="text-lg font-semibold mt-4 ml-4">Počet produktov v košíku: {{ $cartCount }}</div>
                    <div class="mt-8 ml-4 flex flex-row mb-2 w-full justify-between items-center pr-10">
                        <div class="text-lg font-semibold">Celková suma:</div>
                        <div class="flex text-2xl font-bold text-black">{{ number_format($cartTotal, 2) }} €</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="flex mt-10 mb-5 px-5">
            <section class="flex flex-1 justify-start">
                <a href="{{ route('cart.index') }}">
                    <button class="border rounded-xl border-gray-200 bg-gray-300 p-2 px-6 hover:bg-gray-400 transition">
                        Späť do košíka
                    </button>
                </a>
            </section>

            <section class="flex flex-1 justify-end">
                <a href="/contact_info">
                    <button class="border rounded-xl border-gray-200 bg-gray-300 p-2 px-6 hover:bg-gray-400 transition">
                        Dodacie údaje
                    </button>
                </a>
            </section>
        </div>
    </div>
    <div class="hidden items-center lg:flex md:w-[5%]"></div>
</main>
@endsection
