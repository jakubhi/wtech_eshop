@extends('layouts.app')

@section('title', 'Pridať nový produkt | Admin')

@section('content')
<main class="items-start w-full p-6 mb-10 flex flex-col md:flex-row gap-x-8">
    <!-- Left main column-->
    <div class="w-full md:w-1/2 flex flex-col">
        <form> 
            <label class="text-2xl font-semibold">Pridať nový produkt</label>
            <p class="text-gray-500">Vytvorte nový produkt s definovanými vlastnosťami</p>
            <label class="text-lg block mt-4 mb-1">Názov produktu</label>
            <input type="text" class="bg-gray-200 rounded-md border focus:ring-brand block w-full mb-6 pl-2 p-2" required>
            
            <label class="text-2xl font-semibold">Detailný opis</label>
            <textarea class="bg-gray-200 w-full p-2 mb-4 rounded-md" rows="5"></textarea>
            
            <div class="grid grid-cols-2 gap-y-4 gap-x-10 w-full mx-auto">
                <div>
                    <label class="text-lg block mb-1">Kategória</label>
                    <input type="text" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                </div>
                <div>
                    <label class="text-lg block mb-1">Cena</label>
                    <input type="number" step="0.01" placeholder="0.00 €" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                </div>

                <div>
                    <label class="text-lg block mb-1">Kusov na sklade</label>
                    <input type="number" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                </div>
                <div>
                    <label class="text-lg block mb-1">Značka</label>
                    <input type="text" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                </div>

                <div>
                    <label class="text-lg block mb-1">Materiál</label>
                    <input type="text" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2">
                </div>
                <div>
                    <label class="text-lg block mb-1">Farba</label>
                    <input type="text" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2">
                </div>
            </div>
            
            <div class="flex gap-x-4 mt-10">
                <button type="submit" class="bg-black text-white px-8 py-3 rounded-md font-bold hover:bg-gray-800 transition">
                    Uložiť produkt
                </button>
                <a href="/admin_dashboard" class="bg-gray-200 text-black px-8 py-3 rounded-md font-bold hover:bg-gray-300 transition text-center">
                    Zrušiť
                </a>
            </div>
        </form>
    </div>

    <!-- Right column (Image Upload Simulation) -->
    <div class="w-full md:w-1/2 flex flex-col mt-10 md:mt-0">
        <label class="text-2xl font-semibold mb-2">Obrázok produktu</label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-10 flex flex-col items-center justify-center bg-gray-50">
            <img src="{{ asset('images/picture.png') }}" alt="Upload icon" class="w-20 mb-4 opacity-50">
            <p class="text-gray-500">Potiahnite obrázok sem alebo kliknite pre výber</p>
            <button class="mt-4 bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 transition">Vybrať súbor</button>
        </div>
    </div>
</main>
@endsection
