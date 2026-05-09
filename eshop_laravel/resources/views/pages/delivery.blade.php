@extends('layouts.app')

@section('title', 'Výber dopravy | E-Shop')

@section('content')
<style>
    #payment-card:checked ~ .card-payment-fields {
        display: block;
    }

    #payment-card:checked + label .payment-indicator {
        background-color: #bfdbfe;
    }
</style>
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

        <form id="delivery-payment-form" action="{{ route('delivery.continue') }}" method="POST" class="flex flex-col mr-5 ml-5">
            @csrf
            @if ($errors->any())
                <div class="mb-4 mt-6 mx-auto w-full max-w-xl p-3 rounded-xl bg-red-100 text-red-700 border border-red-300 text-center font-medium">
                    Pred pokračovaním prosím vyplňte platobné údaje.
                </div>
            @endif
            <div class="flex flex-col md:flex-row w-full mt-10">
                <div class="flex flex-col md:w-7/12 px-5">
                    <span class="font-bold text-xl py-5">Zvoľte spôsob doručenia</span>
                    
                    <div class="flex flex-col gap-y-3">
                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="delivery_method" value="posta" required @checked(old('delivery_method') === 'posta')>
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300"></span>
                            <span class="text-lg ml-5">Doručiť do Eshop boxu</span>
                        </label>

                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="delivery_method" value="kurier" required @checked(old('delivery_method') === 'kurier')>
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300"></span>
                            <span class="text-lg ml-5">Doručenie domov</span>
                        </label>

                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="delivery_method" value="osobny_odber" required @checked(old('delivery_method') === 'osobny_odber')>
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300"></span>
                            <span class="text-lg ml-5">Osobné vyzdvihnutie na pobočke</span>
                        </label>
                    </div>

                    <hr class="mt-10 mb-5 border-[#D9D9D9]">
                    
                    <div class="flex flex-col gap-y-2">
                        <span class="font-bold text-xl py-5">Zvoľte spôsob platby</span>
                        
                        <div>
                            <input type="radio" class="hidden peer" name="payment_method" id="payment-card" value="card" required @checked(old('payment_method') === 'card')>
                            <label for="payment-card" class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                                <span class="payment-indicator w-7 h-7 rounded-xl bg-gray-300"></span>
                                <span class="text-lg ml-5">Kartou online</span>
                            </label>
                            <div class="card-payment-fields hidden mt-2 p-4 border border-[#D9D9D9] rounded-xl bg-gray-50">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                    <div class="lg:col-span-2">
                                        <label for="card-owner" class="font-semibold text-sm mb-1 block">Meno na karte <span class="text-red-600">*</span></label>
                                        <input id="card-owner" name="card_owner" type="text" value="{{ old('card_owner') }}" placeholder="Meno Priezvisko" pattern="[A-Za-zÀ-ž][A-Za-zÀ-ž '\\-]*" title="Meno na karte môže obsahovať iba písmená, medzery, apostrof a pomlčku." class="w-full px-4 py-2 bg-white border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('card_owner') ring-2 ring-red-400 @enderror">
                                    </div>
                                    <div class="lg:col-span-2">
                                        <label for="card-number" class="font-semibold text-sm mb-1 block">Číslo karty <span class="text-red-600">*</span></label>
                                        <input id="card-number" name="card_number" type="text" value="{{ old('card_number') }}" inputmode="numeric" maxlength="19" placeholder="1234 5678 9012 3456" pattern="[0-9 ]{13,19}" title="Číslo karty musí mať 13 až 19 číslic." class="w-full px-4 py-2 bg-white border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('card_number') ring-2 ring-red-400 @enderror">
                                    </div>
                                    <div>
                                        <label for="card-expiry" class="font-semibold text-sm mb-1 block">Platnosť (MM/RR) <span class="text-red-600">*</span></label>
                                        <input id="card-expiry" name="card_expiry" type="text" value="{{ old('card_expiry') }}" inputmode="numeric" maxlength="5" placeholder="MM/RR" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Platnosť musí byť vo formáte MM/RR." class="w-full px-4 py-2 bg-white border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('card_expiry') ring-2 ring-red-400 @enderror">
                                    </div>
                                    <div>
                                        <label for="card-cvv" class="font-semibold text-sm mb-1 block">CVV <span class="text-red-600">*</span></label>
                                        <input id="card-cvv" name="card_cvv" type="text" value="{{ old('card_cvv') }}" inputmode="numeric" maxlength="4" placeholder="123" pattern="[0-9]{3,4}" title="CVV musí mať 3 alebo 4 číslice." class="w-full px-4 py-2 bg-white border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('card_cvv') ring-2 ring-red-400 @enderror">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="payment_method" value="cash" required @checked(old('payment_method') === 'cash')>
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300"></span>
                            <span class="text-lg ml-5">Platba pri prevzatí</span>
                        </label>

                        <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9] cursor-pointer">
                            <input type="radio" class="hidden peer" name="payment_method" value="transfer" required @checked(old('payment_method') === 'transfer')>
                            <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300"></span>
                            <span class="text-lg ml-5">Platba prevodom na účet</span>
                        </label>
                    </div>                        
                </div>

                <div class="flex flex-col bg-gray-100 md:w-1/3 md:h-fit md:m-8 pb-6 mt-10 rounded-xl shadow-sm">
                    <div class="text-3xl font-bold mt-6 flex justify-center border-b pb-4 mx-4">Zhrnutie</div>
                    <div class="text-lg font-semibold mt-4 ml-4">Počet produktov v košíku: {{ $cartCount }}</div>
                    <div class="mt-8 ml-4 mr-4 flex flex-row mb-2 justify-between items-center">
                        <div class="text-lg font-semibold">Celková suma:</div>
                        <div class="flex text-2xl font-bold text-black">{{ number_format($cartTotal, 2) }} €</div>
                    </div>
                </div>
            </div>
        <div class="flex mt-10 mb-5 px-5">
            <section class="flex flex-1 justify-start">
                <a href="{{ route('cart.index') }}">
                    <button type="button" class="border rounded-xl border-gray-200 bg-gray-300 p-2 px-6 hover:bg-gray-400 transition">
                        Späť do košíka
                    </button>
                </a>
            </section>

            <section class="flex flex-1 justify-end">
                <button type="submit" class="border rounded-xl border-gray-200 bg-gray-300 p-2 px-6 hover:bg-gray-400 transition">
                    Dodacie údaje
                </button>
            </section>
        </div>
        </form>
    </div>
    <div class="hidden items-center lg:flex md:w-[5%]"></div>
</main>
@endsection
