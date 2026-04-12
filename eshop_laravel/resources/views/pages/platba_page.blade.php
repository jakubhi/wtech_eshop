@extends('layouts.app')

@section('title', 'Potvrdenie platby | E-Shop')

@section('content')
<main class="flex flex-col grow justify-center items-center py-20">
    <div class="flex flex-col items-center">
        <div class="flex justify-center w-fit mx-4 p-4 sm:px-10 lg:px-40 bg-gray-400 mb-2 sm:text-xl md:text-2xl lg:text-3xl font-bold rounded-lg text-center shadow-lg">
            Platba prebehla úspešne. Ďakujeme za Váš nákup!
        </div>
        <section class="flex justify-center mt-10">
            <a href="/">
                <button class="border rounded-xl border-gray-200 bg-gray-300 p-4 px-10 hover:bg-gray-400 transition font-bold text-lg">
                    Prejsť na hlavnú stránku
                </button>
            </a>
        </section>
    </div>
</main>
@endsection
