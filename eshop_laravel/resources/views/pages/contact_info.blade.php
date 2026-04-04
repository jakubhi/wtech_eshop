<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktné informácie | E-Shop</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="flex flex-col min-h-screen border-2">
    
      <header class="
      bg-black
        flex justify-between items-center flex-row text-md
        p-1
        m:text-xl
        lg:pr-4
      ">
        <a href="/">
            <div class="hidden items-center justify-center bg-[#2D2D2D] text-white border border-gray-200 rounded-full font-bold
                md:flex md:ml-1 md:px-3 md:py-2 md:mr-1
                lg:ml-3 lg:px-10
            ">
                ToJa Clothes
            </div>
        </a>
        
        <a href="/" class="flex md:hidden invert hover:opacity-80">
            <img src="../images/home.png" alt="Domov" class="w-10 p-1">
        </a>

        <div class="flex flex-1 justify-center px-4">  
            <div class="relative w-full sm:max-w-md md:max-w-2xl lg:max-w-lg xl:max-w-4xl">
                <div class="flex items-center absolute inset-y-0 pl-2 sm:pl-4 md:pl-5 p-1">
                    <img src="../images/lupa.png" alt="Vyhladat" class="w-5 h-5 sm:w-6 sm:h-6">
                </div>
                <input type="search" placeholder="Hľadáte niečo?" class="bg-[#2D2D2D] text-white text-center rounded-full 
                    border
                    p-1 ml-1 mr-3 w-full
                    sm:max-w-md
                    md:max-w-xl lg:p-2 lg:m-1.5
                    lg:max-w-lg 
                    xl:max-w-4xl 
                ">
            </div>
            
        </div>
        
        <div class="flex items-center justify-between">
            <a href="/login" class="bg-[#2D2D2D] border border-white text-white
                hidden text-xs rounded-full
                sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-2 sm:p-1
                md:text-lg
                hover:brightness-85 active:brightness-85
            ">
                Hosť - Login
            </a>

            <a href="/login">
                <img src="../images/user.png" alt="profile" class="h-10 pr-2 invert hover:opacity-80">
            </a>
            <a href="/cart">
                <img src="../images/cart.png" alt="cart" class="h-10 pr-2 invert hover:opacity-80">
            </a>
            
            <span class="flex items-center pr-3 pl-1
                text-white
                sm:text-lg
                lg:text-xl
                xl:text-2xl
            ">0.00 €</span>
        </div>
        
      </header>

      <main class="flex flex-row grow border-2 bg-white border-lime-900">

        <div class="
            hidden items-center
            lg:flex md:w-[5%]
        ">
        </div>

          <div class="flex flex-col grow">
                  
            <nav class="borders
                grid grid-cols-3 py-2 px-15 items-center gap-x-20
                
            ">
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


            <form class="flex flex-col flex-1 px-5 mt-10 ">
    
                <h1 class="flex flex-row font-bold text-lg justify-center py-2">
                    Kontaktné údaje
                </h1>
                
                <div class="flex flex-col lg:flex-row lg:gap-10">
                    <div class="flex flex-col flex-1 py-1 lg:py-5">
                        <label class="font-bold text-sm mb-1 ml-3">
                            Krstné meno
                        </label>
                        <input 
                            type="text" 
                            placeholder="Krstné meno" 
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />

                        <label class="font-bold text-sm mt-3 mb-1 ml-3">
                            Telefonne číslo
                        </label>
                        <input 
                            type="tel" 
                            placeholder="+421 ... ... ..." 
                            autocomplete="tel"
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />
                    </div>

                    <div class="flex flex-col flex-1 py-5">
                        <label class="font-bold text-sm mb-1 ml-3">
                            Priezvisko
                        </label>
                        <input 
                            type="text" 
                            placeholder="Priezvisko" 
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />

                        <label class="font-bold text-sm mt-3 mb-1 ml-3">
                            Emailová adresa
                        </label>
                        <input 
                            type="text" 
                            placeholder="your@email.com"
                            autocomplete="email"
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        >
                    </div>

                </div>
                <div class="w-full mt-5 lg:mt-10 h-[0.5px] bg-gray-200"></div>
                <h1 class="flex flex-col items-center font-bold text-lg sm:mt-3 justify-center py-2">
                        Adresa doručenia
                </h1>

                <div class="flex flex-col lg:flex-row lg:gap-10">
                    <div class="flex flex-col flex-1 py-1 lg:py-5">
                        <label class="font-bold text-sm mb-1 ml-3">
                            Mesto
                        </label>
                        <input 
                            type="text" 
                            placeholder="Mesto" 
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />

                        <label class="font-bold text-sm mt-3 mb-1 ml-3">
                            Smerové číslo (PSČ)
                        </label>
                        <input 
                            type="text" 
                            placeholder="PSČ" 
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />
                    </div>

                    <div class="flex flex-col flex-1 py-5">
                        <label class="font-bold text-sm mb-1 ml-3">
                            Ulica
                        </label>
                        <input 
                            type="text" 
                            placeholder="Ulica, číslo" 
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />

                        <label class="font-bold text-sm mt-3 mb-1 ml-3">
                            Štát
                        </label>
                        <input 
                            type="text" 
                            placeholder="Slovenská republika" 
                            class="px-4 ml-2 mr-2 py-2 lg:py-3 bg-gray-200 rounded-2xl"
                        />
                    </div>

                </div>
                <div class="flex flex-1"></div>

                <div class="flex">
                    <section class="flex flex-1 justify-start mt-10 mb-5">
                        <a href="/delivery" class="border rounded-xl border-gray-200 bg-gray-300
                                p-2 mt-6 mb-6 items-center
                                md:p-2 md:mb-6
                                lg:p-4 lg:mr-6 lg:mb-10 lg:mt-15
                            ">
                                Späť k voľbe dopravy
                        </a>
                    </section>

                    <section class="flex flex-1 justify-end mt-10 mb-5">
                        <a href="/payment" class="border rounded-xl border-gray-200 bg-gray-300
                                p-2 mt-6 mb-6 items-center
                                md:p-2 md:mb-6
                                lg:p-4 lg:mr-6 lg:mb-10 lg:mt-15

                            ">
                                Zaplatiť a objednať
                        </a>
                    </section>
                </div>
            </div>
        </div>

        <div class="
            hidden items-center
            lg:flex md:w-[5%]
        ">
        </div>

    </main>

    <footer class="flex justify-center bg-[#2D2D2D] text-white 
        h-[10%]
        text-sm items-center py-2 text-center
        sm:text-base sm:px-5
        md:text-md
        lg:text-lg lg:px-10
    ">
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
                            <img src="../images/facebook.png" class="invert object-contain">
                        </div>
                        <span>Facebook</span>
                    </li>
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="../images/instagram.png" class="invert object-contain">
                        </div>
                        <span>Instagram</span>
                    </li>
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="../images/youtube.png" class="invert object-contain">
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
</body>

</html>