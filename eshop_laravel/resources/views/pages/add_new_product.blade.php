@extends('layouts.app')

@section('title', 'Pridať nový produkt | Admin')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-5 mb-4">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-5 mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<main class="items-start w-full p-6 mb-10 flex flex-col md:flex-row gap-x-8">
    <!-- Left main column-->
    <div class="w-full md:w-1/2 flex flex-col">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"> 
            @csrf
            <label class="text-2xl font-semibold">Pridať nový produkt</label>
            <p class="text-gray-500">Vytvorte nový produkt s definovanými vlastnosťami</p>
            <label class="text-lg block mt-4 mb-1">Názov produktu</label>
            <input type="text" name="nazov" class="bg-gray-200 rounded-md border focus:ring-brand block w-full mb-6 pl-2 p-2" required>
            
            <label class="text-2xl font-semibold">Detailný opis</label>
            <textarea name="popis" class="bg-gray-200 w-full p-2 mb-4 rounded-md" rows="5"></textarea>
            
            <div class="grid grid-cols-2 gap-y-4 gap-x-10 w-full mx-auto">
                <div>
                    <label class="text-lg block mb-1">Kategória</label>
                    <select name="kategoria_id" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                        <option value="">Vyberte kategóriu</option>
                        <option value="1">Tričká</option>
                        <option value="2">Mikiny</option>
                        <option value="3">Sukne</option>
                        <option value="4">Topánky</option>
                        <option value="5">Tenisky</option>
                        <option value="6">Vysoké podpätky</option>
                        <option value="7">Nohavice</option>
                        <option value="8">Kraťasy</option>
                        <option value="9">Spodné prádlo</option>
                        <option value="10">Ponožky</option>
                        <option value="11">Šiltovky</option>
                        <option value="12">Tielka</option>
                        <option value="13">Bundy</option>
                        <option value="14">Košele</option>
                        <option value="15">Doplnky</option>
                        <option value="16">Šaty</option>
                    </select>
                </div>
                <div>
                    <label class="text-lg block mb-1">Cena</label>
                    <input type="number" name="cena" step="0.01" placeholder="0.00 €" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                </div>

                <div>
                    <label class="text-lg block mb-1">Kusov na sklade</label>
                    <input type="number" name="skladom" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                </div>
                <div>
                    <label class="text-lg block mb-1">Značka</label>
                    <select name="znacka_id" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                        <option value="">Vyberte značku</option>
                        <option value="1">Nike</option>
                        <option value="2">Adidas</option>
                        <option value="3">Puma</option>
                        <option value="4">Zara</option>
                        <option value="5">H&M</option>
                        <option value="6">Levis</option>
                    </select>
                </div>

                <div>
                    <label class="text-lg block mb-1">Materiál</label>
                    <input type="text" name="material" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2">
                </div>
                <div>
                    <label class="text-lg block mb-1">Farba</label>
                    <select name="farba" class="bg-gray-200 rounded-md border focus:ring-brand block w-full pl-2 p-2" required>
                        <option value="">Vyberte farbu</option>
                        <option value="blue">Modrá</option>
                        <option value="black">Čierna</option>
                        <option value="white">Biela</option>
                        <option value="red">Červená</option>
                        <option value="green">Zelená</option>
                    </select>
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

    <!-- Right column (Image Upload) -->
    <div class="w-full md:w-1/2 flex flex-col mt-10 md:mt-0">
        <label class="text-2xl font-semibold mb-2">Obrázky produktu</label>
        
        <!-- First Image Upload -->
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 mb-4">
            <p class="text-gray-600 font-medium mb-3">Prvý obrázok</p>
            <input type="file" name="image1" id="image-upload-1" class="hidden" accept="image/*">
            <button type="button" onclick="document.getElementById('image-upload-1').click()" class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 transition"> Nahrať prvý obrázok</button>
            <div id="image-preview-1" class="mt-4 hidden">
                <img src="" alt="Preview 1" class="max-h-32 rounded">
                <p class="text-sm text-gray-600 mt-2"></p>
            </div>
        </div>

        <!-- Second Image Upload -->
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50">
            <p class="text-gray-600 font-medium mb-3">Druhý obrázok</p>
            <input type="file" name="image2" id="image-upload-2" class="hidden" accept="image/*">
            <button type="button" onclick="document.getElementById('image-upload-2').click()" class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 transition"> Nahrať druhý obrázok</button>
            <div id="image-preview-2" class="mt-4 hidden">
                <img src="" alt="Preview 2" class="max-h-32 rounded">
                <p class="text-sm text-gray-600 mt-2"></p>
            </div>
        </div>
    </div>
</main>

<script>
// Handle first image upload
document.getElementById('image-upload-1').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview-1');
    const previewImg = preview.querySelector('img');
    const previewText = preview.querySelector('p');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewText.textContent = file.name;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});

// Handle second image upload
document.getElementById('image-upload-2').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview-2');
    const previewImg = preview.querySelector('img');
    const previewText = preview.querySelector('p');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewText.textContent = file.name;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endsection
