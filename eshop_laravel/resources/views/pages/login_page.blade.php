@extends('layouts.app')

@section('title', 'Prihlásenie | E-Shop')

@section('content')
    <main class="flex flex-col items-center grow justify-center py-10">
        <div class="text-lg mb-2">Vitajte v našom Eshope!</div>
        @if (session('status'))
            <div class="mb-4 w-full max-w-md rounded-md border-2 border-green-700 bg-green-100 px-3 py-2 text-sm text-green-900" role="status">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST" class="bg-gray-300 border-4 
            flex flex-col items-center px-6 py-10 gap-y-1
            sm:w-[45%]
            md:w-[40%]
            lg:w-[35%]
            xl:w-[30%]
        ">
            @csrf
            <div class="bg-[#d7d7d7] rounded-md border-black border-2 w-full sm:w-[90%] md:w-[80%] lg:w-[70%] mb-4">
                <label class="ml-2 px-2 block">Login</label>
                <input name="login" type="text" class="w-full bg-transparent outline-none pl-2 font-bold @error('login') border-red-500 @enderror" autocomplete="username" value="{{ old('login') }}" required autofocus>
            </div>
            <div class="bg-[#d7d7d7] rounded-md border-black border-2 w-full sm:w-[90%] md:w-[80%] lg:w-[70%] mb-4">
                <label class="ml-2 px-2 block">Heslo</label>
                <input name="password" type="password" class="w-full bg-transparent outline-none pl-2 font-bold @error('password') border-red-500 @enderror" autocomplete="current-password" required>
            </div>
            @error('login')
            <span class="text-xs text-red-600 mb-2">Zadali ste nesprávne údaje</span>
            @enderror
            @error('password')
                <span class="text-xs text-red-600 mb-2">Zadali ste nesprávne údaje</span>
            @enderror

            <button type="submit" class="items-center px-6 rounded-md font-bold border-2 border-black hover:bg-gray-300 hover:text-white
                p-1
                mt-3
            ">
                Prihlásenie
            </button>
            <p class="mt-4">
                Zabudli ste heslo?
            </p>
            <p>Nemáte ešte účet? <a href="{{ route('register', ['type' => 'zakaznik']) }}" class="text-blue-500 hover:text-blue-800 underline">Registrujte sa tu!</a></p>
            <p class="italic mt-4 text-xs text-gray-600">
                Ste administrátor? 
                <a href="{{ route('register', ['type' => 'admin']) }}" class="text-gray-600 hover:text-gray-800 underline">
                    Registrujte sa tu!
                </a>
            </p>
        </form>
    </main>
@endsection
