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
            <h1 class="flex flex-row font-bold text-lg justify-center py-2">
                Kontaktné údaje
            </h1>
            
            <div class="flex flex-col lg:flex-row lg:gap-10">
                <div class="flex flex-col flex-1 py-1 lg:py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Krstné meno</label>
                    <input type="text" placeholder="Krstné meno" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Telefonne číslo</label>
                    <input type="tel" placeholder="+421 ... ... ..." autocomplete="tel" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>
                </div>

                <div class="flex flex-col flex-1 py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Priezvisko</label>
                    <input type="text" placeholder="Priezvisko" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Emailová adresa</label>
                    <input type="text" placeholder="your@email.com" autocomplete="email" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300">
                </div>
            </div>

            <div class="w-full mt-5 lg:mt-10 h-[0.5px] bg-gray-200"></div>
            
            <h1 class="flex flex-col items-center font-bold text-lg sm:mt-3 justify-center py-2">
                Adresa doručenia
            </h1>

            <div class="flex flex-col lg:flex-row lg:gap-10">
                <div class="flex flex-col flex-1 py-1 lg:py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Mesto</label>
                    <input type="text" placeholder="Mesto" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Smerové číslo (PSČ)</label>
                    <input type="text" placeholder="PSČ" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>
                </div>

                <div class="flex flex-col flex-1 py-5">
                    <label class="font-bold text-sm mb-1 ml-3">Ulica</label>
                    <input type="text" placeholder="Ulica, číslo" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>

                    <label class="font-bold text-sm mt-3 mb-1 ml-3">Štát</label>
                    <input type="text" placeholder="Slovenská republika" class="px-4 py-2 lg:py-3 bg-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-gray-300"/>
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
