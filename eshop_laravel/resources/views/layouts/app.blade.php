<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-shop')</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen">
    
      <x-header />

      <main class="flex flex-col grow">
        @yield('content')
      </main>

      <footer class="flex justify-center bg-[#2D2D2D] text-white h-[10%] text-sm items-center py-2 text-center sm:text-base sm:px-5 md:text-md lg:text-lg lg:px-10">
        <div class="grid grid-cols-1 space-y-5 sm:grid-cols-3 justify-between items-start text-center">
            <div class="">
                <p class="font-bold">Potrebujete pomôcť?</p>
                <ul class="space-y-1">
                    <li>Navštívte našu pobočku:</li>
                    <li>Po-Pia 9:00 - 20:00</li>
                    <li>alebo</li>
                    <li>volajte +421 999 999 999</li>
                </ul>
            </div>
            <div class="hidden sm:flex justify-center items-center self-center text-center">
                <p class="font-semibold hidden sm:flex items-center">Copyright 2026, H & H, všetky práva vyhradené</p>
            </div>
            <div class="flex flex-col justify-center items-center">
                <p class="font-bold">Sociálne médiá</p>
                <ul class="space-y-2 flex flex-col items-center">
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="{{ asset('images/facebook.png') }}" alt="Facebook icon" class="invert object-contain">
                        </div>
                        <span>Facebook</span>
                    </li>
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="{{ asset('images/instagram.png') }}" alt="Instagram icon" class="invert object-contain">
                        </div>
                        <span>Instagram</span>
                    </li>
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="{{ asset('images/youtube.png') }}" alt="YouTube icon" class="invert object-contain">
                        </div>
                        <span>YouTube</span>
                    </li>
                </ul>
            </div>
            <div class="text-center">
                <p class="font-semibold sm:hidden ">Copyright 2026, H & H, všetky práva vyhradené</p>
            </div>
        </div>
      </footer>
    </div>
</body>
</html>
