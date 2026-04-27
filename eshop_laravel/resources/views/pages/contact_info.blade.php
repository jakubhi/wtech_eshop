@extends('layouts.app')

@section('title', 'Kontaktné informácie | E-Shop')

@section('content')
<main class="flex flex-row grow bg-white">
    <div class="hidden items-center lg:flex md:w-[5%]"></div>

    <div class="flex flex-col grow">
        <nav class="grid grid-cols-3 py-2 px-15 items-center gap-x-20">
            <div class="flex flex-col items-center">
                <span>Košík</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 bg-[#D9D9D9]">1</span>
            </div>
            
            <div class="flex flex-col items-center">
                <span>Doprava</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 bg-[#D9D9D9]">2</span>
            </div>

            <div class="flex flex-col font-bold items-center whitespace-nowrap">
                <span>Dodacie údaje</span>
                <span class="flex rounded-full items-center justify-center w-10 h-10 text-white bg-black">3</span>
            </div>
        </nav>

        <form action="{{ route('order.process') }}" method="POST" class="flex flex-col flex-1 px-5 mt-10">
            @csrf
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-700 border border-red-300">
                    Prosím, opravte označené polia vo formulári.
                </div>
            @endif
            <h1 class="flex flex-row font-bold text-lg justify-center py-2">
                Kontaktné údaje
            </h1>
            
            <div class="flex flex-col lg:flex-row lg:gap-10">
                <div class="flex flex-col flex-1 py-1 lg:py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Krstné meno <span class="text-red-600">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Krstné meno" required minlength="2" maxlength="50" pattern="[A-Za-zÀ-ž][A-Za-zÀ-ž '\\-]*" title="Meno môže obsahovať iba písmená, medzery, apostrof a pomlčku." class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('first_name') ring-2 ring-red-400 @enderror"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Telefonne číslo <span class="text-red-600">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+421 ... ... ..." autocomplete="tel" required pattern="^\+?[0-9 ]{9,15}$" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('phone') ring-2 ring-red-400 @enderror"/>
                </div>

                <div class="flex flex-col flex-1 py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Priezvisko <span class="text-red-600">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Priezvisko" required minlength="2" maxlength="50" pattern="[A-Za-zÀ-ž][A-Za-zÀ-ž '\\-]*" title="Priezvisko môže obsahovať iba písmená, medzery, apostrof a pomlčku." class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('last_name') ring-2 ring-red-400 @enderror"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Emailová adresa <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" autocomplete="email" required class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('email') ring-2 ring-red-400 @enderror">
                </div>
            </div>

            <div class="w-full mt-5 lg:mt-10 h-[0.5px] bg-gray-200"></div>
            
            <h1 class="flex flex-col items-center font-bold text-lg sm:mt-3 justify-center py-2">
                Adresa doručenia
            </h1>

            <div class="flex flex-col lg:flex-row lg:gap-10">
                <div class="flex flex-col flex-1 py-1 lg:py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Mesto <span class="text-red-600">*</span></label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Mesto" required minlength="2" maxlength="80" pattern="[A-Za-zÀ-ž][A-Za-zÀ-ž '\\-]*" title="Mesto môže obsahovať iba písmená, medzery, apostrof a pomlčku." class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('city') ring-2 ring-red-400 @enderror"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Smerové číslo (PSČ) <span class="text-red-600">*</span></label>
                    <input type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="PSČ" required pattern="^[0-9]{3}\s?[0-9]{2}$" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('zip_code') ring-2 ring-red-400 @enderror"/>
                </div>

                <div class="flex flex-col flex-1 py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Ulica <span class="text-red-600">*</span></label>
                    <input type="text" name="street" value="{{ old('street') }}" placeholder="Ulica, číslo" required minlength="3" maxlength="120" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('street') ring-2 ring-red-400 @enderror"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Štát <span class="text-red-600">*</span></label>
                    <input type="text" name="country" value="{{ old('country', 'Slovenská republika') }}" placeholder="Slovenská republika" required minlength="2" maxlength="80" pattern="[A-Za-zÀ-ž][A-Za-zÀ-ž '\\-]*" title="Štát môže obsahovať iba písmená, medzery, apostrof a pomlčku." class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300 @error('country') ring-2 ring-red-400 @enderror"/>
                </div>
            </div>

            <div class="flex mt-10 mb-10">
                <section class="flex flex-1 justify-start">
                    <a href="/delivery" class="border rounded-xl border-gray-200 bg-gray-300 p-3 px-6 hover:bg-gray-400 transition">
                        Späť k voľbe dopravy
                    </a>
                </section>

                <section class="flex flex-1 justify-end">
                    <button type="submit" class="border rounded-xl border-gray-200 bg-gray-300 p-3 px-6 hover:bg-gray-400 transition">
                        Zaplatiť a objednať
                    </button>
                </section>
            </div>
        </form>
    </div>

    <div class="hidden items-center lg:flex md:w-[5%]"></div>
</main>
@endsection
