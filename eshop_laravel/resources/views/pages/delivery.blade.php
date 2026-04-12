<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Výber dopravy | E-Shop</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-200">
    <div class="flex flex-col min-h-screen">
    
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
        
        <a href="/">
            <img src="../images/home.png" alt="Presmerovat domov" class="w-10 p-1">
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
            <a href="/login">
                <button class="bg-[#2D2D2D] border border-white text-white
                    hidden text-xs rounded-full
                    sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-2 sm:p-1
                    md:text-lg
                    hover:brightness-85 active:brightness-85
                ">
                    Hosť - Login
                </button>
            </a>

            <a href="/login">
                <img src="../images/user.png" alt="profil" class="h-10 pr-2 invert hover:opacity-80">
            </a>
            <a href="/cart">
                <img src="../images/cart.png" alt="nakupny vozik" class="h-10 pr-2 invert hover:opacity-80">
            </a>
            
            <span class="flex items-center pr-3 pl-1
                text-white
                sm:text-lg
                lg:text-xl
                xl:text-2xl
            ">0.00 €</span>
        </div>
        
      </header>

      <main class="flex flex-row flex-1 bg-white">
        <div class="
            hidden items-center
            lg:flex md:w-[5%]
        ">
        </div>
        
          <div class="flex flex-col flex-1 bg-white">
                <nav class=" bg-white
                    grid grid-cols-3 py-2 px-15 items-center gap-x-20
                ">
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
                            <span class="font-bold text-xl py-5">
                                Zvoľte spôsob doručenia
                            </span>
                            
                            <div class="flex flex-col gap-y-3">
                                <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9]">
                                    <input type="radio" class="hidden peer" name="doprava">
                                    <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300">
                                    </span>
                                    <span class="text-lg ml-5">
                                        Doručiť do Eshop boxu
                                    </span>
                                </label>

                                <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9]">
                                    <input type="radio" class="hidden peer" name="doprava">
                                    <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300">
                                    </span>
                                    <span class="text-lg ml-5">
                                        Doručenie domov
                                    </span>
                                </label>

                                <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9]">
                                    <input type="radio" class="hidden peer" name="doprava">
                                    <span class="w-7 h-7 rounded-xl peer-checked:bg-green-300 bg-gray-300">
                                    </span>
                                    <span class="text-lg ml-5">
                                        Osobné vyzdvihnutie na pobočke
                                    </span>
                                </label>
                            </div>

                            <hr class="mt-10 mb-5 border-[#D9D9D9]">
                            
                            <div class="flex flex-col gap-y-2">
                                <span class="font-bold text-xl py-5">
                                    Zvoľte spôsob platby
                                </span>
                                
                                <div class="rounded-xl border border-[#D9D9D9] overflow-hidden">
                                    <label class="flex cursor-pointer items-center p-4" for="platba_online">
                                        <input type="radio" id="platba_online" name="platba" value="online" class="peer hidden">
                                        <span class="h-7 w-7 shrink-0 rounded-xl border border-slate-300 bg-gray-300 peer-checked:bg-blue-200 peer-checked:border-slate-400">
                                        </span>
                                        <span class="ml-5 text-lg">
                                            Kartou online
                                        </span>
                                    </label>
                                    <div id="card-details-panel" hidden class="border-t border-slate-200">
                                        <div class="space-y-3 px-4 pb-4 pt-3 sm:px-5">
                                            <input type="text" name="card_number" inputmode="numeric" autocomplete="cc-number" maxlength="19" placeholder="Cislo Karty" class="w-full rounded-md border border-slate-400 bg-white px-3 py-2.5 text-slate-600 placeholder:text-slate-400 outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-400 mb-2">
                                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                                <input type="text" name="card_exp_month" inputmode="numeric" autocomplete="cc-exp-month" maxlength="2" placeholder="Mesiac" aria-label="Mesiac" class="w-full rounded-md border border-slate-400 bg-white px-3 py-2.5 text-slate-600 placeholder:text-slate-400 outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-400">
                                                <input type="text" name="card_exp_year" inputmode="numeric" autocomplete="cc-exp-year" maxlength="4" placeholder="Rok" aria-label="Rok" class="w-full rounded-md border border-slate-400 bg-white px-3 py-2.5 text-slate-600 placeholder:text-slate-400 outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-400">
                                            </div>
                                            <input type="text" name="card_cvv" inputmode="numeric"  maxlength="4" placeholder="cvv" class="box-border h-10 w-20 shrink-0 rounded-md border border-slate-400 bg-white px-2 text-center text-sm text-slate-600 placeholder:text-slate-400 outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-400 sm:w-24 mt-2">
                                        </div>
                                    </div>
                                </div>
                                
                                <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9]">
                                    <input type="radio" class="hidden peer" name="platba">
                                    <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300">
                                    </span>
                                    <span class="text-lg ml-5">
                                        Platba pri prevzatí
                                    </span>
                                </label>

                                <label class="flex items-center p-4 rounded-xl border border-[#D9D9D9]">
                                    <input type="radio" class="hidden peer" name="platba">
                                    <span class="w-7 h-7 rounded-xl peer-checked:bg-blue-200 bg-gray-300">
                                    </span>
                                    <span class="text-lg ml-5">
                                        Platba prevodom na účet
                                    </span>
                                </label>
                            </div>                        
                        </div>

                        <div class="flex flex-col bg-gray-100 md:w-1/3 md:h-fit md:m-8 pb-6 mt-10">
                            <div class="text-3xl font-bold mt-6 flex justify-center">Zhrnutie</div>
                            <div class="text-lg font-semibold mt-4 ml-4">Počet produktov v košíku: 3</div>
                            <div class="text-lg font-semibold mt-1 ml-4">Celkom ušetrené 5,51€</div>
                            <div class="mt-8 ml-4 flex flex-row mb-2 w-full justify-between">
                                <div class="text-lg font-semibold">Celková suma:</div>
                                <div class="flex text-2xl font-semibold mr-10">75,48 €</div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex mt-10 mb-5">
                    <section class="flex flex-1 justify-start">
                        <a href="/cart">
                            <button class="border rounded-xl border-gray-200 bg-gray-300
                                p-2 mt-6 mb-6 items-center ml-5
                                md:p-2 md:mb-6 md:ml-5
                                lg:p-4 lg:mr-6 lg:mb-10 lg:mt-15
                            ">
                                Späť do košíka
                            </button>
                        </a>
                    </section>

                    <section class="flex flex-1 justify-end mr-5">
                        <a href="/contact_info">
                            <button class="border rounded-xl border-gray-200 bg-gray-300
                                p-2 mt-6 mb-6 items-center w-full
                                md:p-2 md:mb-6 md:mr-5
                                lg:p-4 lg:mr-6 lg:mb-10 lg:mt-15

                            ">
                                Dodacie údaje
                            </button>
                        </a>
                    </section>
                </div>
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
                            <img src="../images/facebook.png" alt="Facebook logo" class="invert object-contain">
                        </div>
                        <span>Facebook</span>
                    </li>
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="../images/instagram.png" alt="Instagram logo" class="invert object-contain">
                        </div>
                        <span>Instagram</span>
                    </li>
                    <li class="flex items-center gap-x-3">
                        <div class="flex w-4 h-4 items-center justify-center">
                            <img src="../images/youtube.png" alt="YouTube logo" class="invert object-contain">
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
      

    <script>
        (function () {
            var online = document.getElementById('platba_online');
            var panel = document.getElementById('card-details-panel');
            if (!online || !panel) return;
            function syncCardPanel() {
                panel.hidden = !online.checked;
            }
            document.querySelectorAll('input[name="platba"]').forEach(function (el) {
                el.addEventListener('change', syncCardPanel);
            });
            syncCardPanel();
        })();
    </script>
</body>

</html>