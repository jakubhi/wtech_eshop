<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard | E-Shop</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
@if($errors->any())
    <div class="max-w-[1400px] mx-auto mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(!$product)
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Chyba:</strong> Produkt nebol nájdený. <a href="/admin_products_review" class="underline">Späť na zoznam produktov</a>
        </div>
    </div>
@else
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
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-[#2D2D2D] border border-white text-white
                    hidden text-xs rounded-full
                    sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-3 sm:p-1
                    md:text-lg
                    hover:brightness-85 active:brightness-85
                ">
                    Admin - Logout
                </button>
            </form>

            <a href="{{ route('login') }}">
                <img src="../images/user.png" alt="profile" class="h-10 pr-2 invert hover:opacity-80">
            </a>
        </div>
        
    </header>

    <main class="items-start w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10 py-8 mb-10 flex flex-col md:flex-row gap-8">
        <!-- Left main column-->
        <div class="w-full md:w-1/2 flex flex-col bg-white rounded-xl shadow-sm p-6">
            <form id="edit-form" action="/admin/products/{{ $product ? $product->produkt_id : '' }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <label class="text-2xl font-semibold">Upraviť produkt</label>
                <p class="text-gray-500">Upravte vlastnosti existujúceho produktu</p>
                
                <label class="text-lg block mt-4 mb-1">Názov produktu</label>
                <input type="text" name="nazov" maxlength="25" value="{{ $product->nazov ?? '' }}" class="bg-gray-200 border border-gray-300 block w-full mb-6 rounded-xl px-3 py-2" required>
                
                <label class="text-2xl font-semibold">Detailný opis</label>
                <textarea name="popis" maxlength="1000" class="bg-gray-200 border border-gray-300 w-full p-3 mb-4 rounded-xl" rows="5">{{ $product->popis ?? '' }}</textarea>
                
                <div class="grid grid-cols-2 gap-y-4 gap-x-10 w-full mx-auto">
                    <!-- row1 -->
                    <div>
                        <label class="text-lg block mb-1">Kategória</label>
                        <select name="kategoria_id" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                            <option value="">Vyberte kategóriu</option>
                            <option value="1" {{ ($product && $product->kategoria_id == 1) ? 'selected' : '' }}>Tričká</option>
                            <option value="2" {{ ($product && $product->kategoria_id == 2) ? 'selected' : '' }}>Mikiny</option>
                            <option value="3" {{ ($product && $product->kategoria_id == 3) ? 'selected' : '' }}>Sukne</option>
                            <option value="4" {{ ($product && $product->kategoria_id == 4) ? 'selected' : '' }}>Topánky</option>
                            <option value="5" {{ ($product && $product->kategoria_id == 5) ? 'selected' : '' }}>Tenisky</option>
                            <option value="6" {{ ($product && $product->kategoria_id == 6) ? 'selected' : '' }}>Vysoké podpätky</option>
                            <option value="7" {{ ($product && $product->kategoria_id == 7) ? 'selected' : '' }}>Nohavice</option>
                            <option value="8" {{ ($product && $product->kategoria_id == 8) ? 'selected' : '' }}>Kraťasy</option>
                            <option value="9" {{ ($product && $product->kategoria_id == 9) ? 'selected' : '' }}>Spodné prádlo</option>
                            <option value="10" {{ ($product && $product->kategoria_id == 10) ? 'selected' : '' }}>Ponožky</option>
                            <option value="11" {{ ($product && $product->kategoria_id == 11) ? 'selected' : '' }}>Šiltovky</option>
                            <option value="12" {{ ($product && $product->kategoria_id == 12) ? 'selected' : '' }}>Tielka</option>
                            <option value="13" {{ ($product && $product->kategoria_id == 13) ? 'selected' : '' }}>Bundy</option>
                            <option value="14" {{ ($product && $product->kategoria_id == 14) ? 'selected' : '' }}>Košele</option>
                            <option value="15" {{ ($product && $product->kategoria_id == 15) ? 'selected' : '' }}>Doplnky</option>
                            <option value="16" {{ ($product && $product->kategoria_id == 16) ? 'selected' : '' }}>Šaty</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Cena bez zľavy</label>
                        <input type="number" name="cena" min="0.01" max="9999.99" step="0.01" value="{{ $product->cena ?? '' }}" placeholder="0.00 €" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>

                    <div>
                        <label class="text-lg block mb-1">Cena so zľavou (voliteľná)</label>
                        <input type="number" name="cena_bez_zlavy" min="0.01" max="9999.99" step="0.01" value="{{ $product->cena_bez_zlavy ?? '' }}" placeholder="Voliteľné" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2">
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Kusov na sklade</label>
                        <input type="number" name="skladom" min="1" step="1" value="{{ $product->skladom ?? '' }}" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Značka</label>
                        <select name="znacka_id" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2" required>
                            <option value="">Vyberte značku</option>
                            <option value="1" {{ ($product && $product->znacka_id == 1) ? 'selected' : '' }}>Nike</option>
                            <option value="2" {{ ($product && $product->znacka_id == 2) ? 'selected' : '' }}>Adidas</option>
                            <option value="3" {{ ($product && $product->znacka_id == 3) ? 'selected' : '' }}>Puma</option>
                            <option value="4" {{ ($product && $product->znacka_id == 4) ? 'selected' : '' }}>Zara</option>
                            <option value="5" {{ ($product && $product->znacka_id == 5) ? 'selected' : '' }}>H&M</option>
                            <option value="6" {{ ($product && $product->znacka_id == 6) ? 'selected' : '' }}>Levis</option>
                        </select>
                    </div>

                    <!-- row3 -->
                    <div>
                        <label class="text-lg block mb-1">Materiál</label>
                        @php
                            $materialOptions = ['Bavlna', 'Polyester', 'Elastan', 'Vlna', 'Denim', 'Koža', 'Viskóza', 'Linen'];
                            $currentMaterial = old('material', $product->material ?? '');
                            $normalizedCurrentMaterial = mb_strtolower(trim((string) $currentMaterial));
                        @endphp
                        <select name="material" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2">
                            <option value="">Vyberte materiál</option>
                            @if($normalizedCurrentMaterial !== '' && !in_array($normalizedCurrentMaterial, array_map(fn($option) => mb_strtolower($option), $materialOptions), true))
                                <option value="{{ $currentMaterial }}" selected>{{ $currentMaterial }}</option>
                            @endif
                            @foreach($materialOptions as $option)
                                <option value="{{ $option }}" {{ $normalizedCurrentMaterial === mb_strtolower($option) ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-lg block mb-1">Farba</label>
                        @php
                            $currentColor = old('farba', $product->farba ?? '');
                            $normalizedCurrentColor = strtolower(trim((string) $currentColor));
                        @endphp
                        <select name="farba" class="bg-gray-200 border border-gray-300 block w-full rounded-xl px-3 py-2">
                            <option value="">Vyberte farbu</option>
                            <option value="modra" {{ $normalizedCurrentColor === 'modra' ? 'selected' : '' }}>Modrá</option>
                            <option value="cierna" {{ $normalizedCurrentColor === 'cierna' ? 'selected' : '' }}>Čierna</option>
                            <option value="biela" {{ $normalizedCurrentColor === 'biela' ? 'selected' : '' }}>Biela</option>
                            <option value="cervena" {{ $normalizedCurrentColor === 'cervena' ? 'selected' : '' }}>Červená</option>
                            <option value="zelena" {{ $normalizedCurrentColor === 'zelena' ? 'selected' : '' }}>Zelená</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right main column -->
        <div class="w-full md:w-1/2 flex flex-col items-center self-stretch bg-white rounded-xl shadow-sm p-6">
            <label class="text-lg flex mt-10 mb-10 justify-center">Obrázky produktu</label>

            <div class="w-full gap-y-5 h-auto rounded-xl flex flex-col items-center justify-center gap-x-20">
                <!-- First Image -->
                <div class="flex flex-col items-center">
                    <div class="flex flex-col gap-4 justify-center overflow-hidden border rounded-lg"> 
                        <img id="current-image-1" src="{{ $product->image_path }}" alt="{{ $product->nazov ?? 'Produkt' }} - obrázok 1" class="w-52 h-70 object-cover">
                    </div>
                    <div class="mt-2">
                        <input type="file" name="image1" id="image-upload-1" class="hidden" accept="image/*" form="edit-form" onchange="previewImage(1, this)">
                        <button type="button" onclick="document.getElementById('image-upload-1').click()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition text-sm">
                            Nahrať nový obrázok 1
                        </button>
                    </div>
                </div>

                <!-- Second Image -->
                <div class="flex flex-col items-center">
                    <div class="flex flex-col gap-4 justify-center overflow-hidden border rounded-lg"> 
                        <img id="current-image-2" src="{{ $product->second_image_path }}" alt="{{ $product->nazov ?? 'Produkt' }} - obrázok 2" class="w-52 h-70 object-cover">
                    </div>
                    <div class="mt-2">
                        <input type="file" name="image2" id="image-upload-2" class="hidden" accept="image/*" form="edit-form" onchange="previewImage(2, this)">
                        <button type="button" onclick="document.getElementById('image-upload-2').click()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition text-sm">
                            Nahrať nový obrázok 2
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-center gap-4">
                <button type="submit" form="edit-form" class="border rounded-xl border-gray-200 bg-green-500 text-white p-3 px-6 hover:bg-green-600 transition font-semibold">
                    Uložiť zmeny
                </button>
                <a href="/admin_products_review">
                    <button type="button" class="border rounded-xl border-gray-200 bg-gray-300 p-3 px-6 hover:bg-gray-400 transition font-semibold">
                        Späť
                    </button>
                </a>
            </div>

            <div class="flex-1"></div>
        </div>
    </main>

    <script>
    function previewImage(imageNumber, input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const currentImage = document.getElementById('current-image-' + imageNumber);
                currentImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
@endif
    </main>
</body>
</html>