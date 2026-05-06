<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard | E-Shop</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <header class="
      bg-black
        flex justify-between items-center flex-row text-md
        p-1
        md:text-xl
        lg:pr-4
      ">
        <a href="/admin_dashboard">
            <div class="hidden items-center justify-center bg-[#2D2D2D] text-white border border-gray-200 rounded-full font-bold
                md:flex md:ml-1 md:px-3 md:py-2 md:mr-1
                lg:ml-3 lg:px-10
            ">
                ToJa Clothes
            </div>
        </a>
        
        <a href="/admin_dashboard" class="flex md:hidden invert hover:opacity-80">
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
            <a href="/login_page" class="bg-[#2D2D2D] border border-white text-white
                hidden text-xs rounded-full
                sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-3 sm:p-1
                md:text-lg
                hover:brightness-85 active:brightness-85
            ">
                Admin - Logout
            </a>

            <a href="/login_page">
                <img src="../images/user.png" alt="profile" class="h-10 pr-2 invert hover:opacity-80">
            </a>
        </div>
        
    </header>

    <main class="items-start w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10 py-8 mb-10 flex flex-col md:flex-row gap-8">
        <!-- Left main column-->
        <div class="w-full md:w-1/2 flex flex-col bg-white rounded-xl shadow-sm p-6">
            <form> 
                <label class="text-2xl font-semibold">Upraviť produkt</label>
                <p class="text-gray-500">Upravte vlastnosti existujúceho produktu</p>
                <label class="text-lg block mt-4 mb-1">Názov produktu</label>
                <input type="text" class="bg-gray-200 border border-gray-300 block w-full mb-6 rounded-xl px-3 py-2" required>
                <label class="text-2xl font-semibold">Detailný opis</label>
                <textarea class="bg-gray-200 border border-gray-300 w-full p-3 mb-4 rounded-xl" rows="5"></textarea>
                <div class="grid grid-cols-2 gap-y-4 gap-x-10 w-full mx-auto">
                    <!-- row1 -->
                    <div>
                        <label class="text-lg block mb-1">Kategória</label>
                        <input type="text" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Cena bez zľavy</label>
                        <input type="number" step="0.01" placeholder="0.00 €" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>

                    <div>
                        <label class="text-lg block mb-1">Akciová cena</label>
                        <input type="number" step="0.01" placeholder="0.00 €" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2">
                    </div>

                    <!-- row2 -->

                    <div>
                        <label class="text-lg block mb-1">Kusov na sklade</label>
                        <input type="number" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Značka</label>
                        <input  type="text" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>

                    <!-- row3 -->

                    <div>
                        <label class="text-lg block mb-1">Materiál</label>
                        <input  type="text" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Obdobie</label>
                        <input  type="text" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>

                    <!-- row4 -->

                    <div>
                        <label class="text-lg block mb-1">Dostupné farby</label>
                        <input type="text" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Dostupné veľkosti</label>
                        <input type="text" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>


                </div>
            </form>
        </div>

        <!-- Right main column -->
        <div class="w-full md:w-1/2 flex flex-col items-center self-stretch bg-white rounded-xl shadow-sm p-6">
            <label class="text-lg flex mt-10 mb-10 justify-center">Obrázky produktu</label>

            <div class="w-fit gap-y-5 h-auto rounded-xl flex flex-col sm:flex-row items-center justify-center cursor-pointer gap-x-20">
                <div class= "flex flex-col md:flex-row gap-4 justify-center overflow-hidden border"> 
                    <img src="../images/jacket1.png" alt="Kožená bunda" class="w-52 h-70">
                </div>

                <div class= "flex flex-col md:flex-row gap-4 justify-center overflow-hidden border"> 
                    <img src="../images/jacket2.png" alt="Kožená bunda" class="w-52 h-70">
                </div>
            </div>

            <div class="mt-10 flex justify-center">
                <a href="/admin_products_review">
                    <button type="button" class="border rounded-xl border-gray-200 bg-gray-300 p-3 px-6 hover:bg-gray-400 transition font-semibold">Upraviť produkt</button>
                </a>
                
            </div>

            <div class="flex-1"></div>

            
        </div>
    </main>