@extends('layouts.app')

@section('title', ($product->nazov ?? 'Produkt') . ' | E-shop')

@section('content')
    <main class="flex flex-row grow border-2">
        <div class="hidden items-center lg:flex md:w-[5%]"></div>

        <div class="flex flex-col grow gap-y-3 lg:mt-10">
            
            
            <div class="flex flex-col lg:flex-row items-center lg:items-start aspect-auto">
                @php
                    $galleryImages = $product->product_gallery;
                @endphp
                <div class="flex flex-row w-[90%] md:w-[65%] lg:w-[38%] m-5 gap-3">
                    <div class="flex flex-col gap-2 w-20">
                        @foreach($galleryImages as $index => $image)
                            <button
                                type="button"
                                onclick="setMainProductImage('{{ $image['path'] }}', {{ $image['is_grayscale'] ? 'true' : 'false' }}, this)"
                                class="product-thumb-btn bg-white border-2 {{ $index === 0 ? 'border-gray-900' : 'border-transparent' }} rounded-md p-1 hover:border-gray-400 transition"
                            >
                                <img src="{{ $image['path'] }}" alt="{{ $product->nazov }} - náhľad {{ $index + 1 }}" class="w-14 h-14 object-contain {{ $image['is_grayscale'] ? 'grayscale' : '' }}">
                            </button>
                        @endforeach
                    </div>
                    <div class="flex-1 flex flex-col bg-gray-200 justify-center items-center p-2 min-h-[18rem]">
                        <img
                            id="main_product_image"
                            src="{{ $galleryImages[0]['path'] ?? $product->image_path }}"
                            alt="{{ $product->nazov }} - hlavný obrázok"
                            class="w-full max-h-[28rem] object-contain {{ !empty($galleryImages[0]['is_grayscale']) ? 'grayscale' : '' }}"
                        >
                    </div>
                </div>

                <div class="flex flex-col flex-1 px-4 ml-5 gap-y-2 self-stretch">
                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold mt-3 text-center">
                            {{ $product->nazov }}
                        </h1>

                        <p class="text-lg pt-3 text-gray-700">
                            Tento produkt {{ $product->nazov }} je vysoko kvalitný kúsok od značky {{ $product->znacka->nazov }}. 
                            Ideálny pre každodenné nosenie, vyrobený z príjemných materiálov, ktoré zaručujú pohodlie po celý deň.
                        </p>
                    </div>

                    <div class="flex flex-col mt-3 gap-y-2 text-lg text-gray-600">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/box.png') }}" alt="Ikona boxu" class="w-5 object-contain">
                            @if($product->skladom > 0)
                                Na sklade: {{ $product->skladom }}ks
                            @else
                                <span class="text-red-500 font-semibold">Momentálne nedostupné</span>
                            @endif
                        </div>

                        @if($product->na_predajni)
                        <div class="flex items-center gap-x-3">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-[10px]">✓</span>
                            </div>
                            Na predajni (možný osobný odber)
                        </div>
                        @endif

                        @if($product->na_objednavku)
                        <div class="flex items-center gap-x-3">
                            <div class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-[10px]">!</span>
                            </div>
                            Na objednávku (dodanie do 7-14 dní)
                        </div>
                        @endif

                        <div class="flex mt-auto items-center gap-x-3">
                            <img src="{{ asset('images/delivery.png') }}" alt="Ikona dopravy" class="w-5 object-contain">
                                Doprava do 24 hodín
                        </div>
                        
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/recycle.png') }}" alt="Ikona vrátenia tovaru" class="w-5 object-contain">
                                Jednoduché vrátenie tovaru
                        </div>
                    </div>

                    <form action="{{ route('cart.add', $product->produkt_id) }}" method="POST" class="flex flex-col items-end">
                        @csrf
                        <div class="flex font-bold text-2xl px-4 py-2 rounded-xl border-gray-400 bg-white ">
                            Cena: {{ number_format($product->cena, 2) }} €
                        </div>

                        <div class="flex items-center justify-end mt-5">
                            <span class="text-md px-4 text-gray-700">
                                Zadajte množstvo:
                            </span>

                            <div class="flex border px-4 border-gray-400 rounded-full items-center gap-x-4 py-1">
                                <button type="button" onclick="decrementQuantity()" class="font-bold">
                                    <img src="{{ asset('images/minus.png') }}" alt="Zmenšiť množstvo" class="w-3">
                                </button>
                                <input type="number" id="quantity_input" name="quantity" value="1" min="1" class="w-10 text-center bg-transparent border-none focus:ring-0">
                                <button type="button" onclick="incrementQuantity()" class="font-bold">
                                    <img src="{{ asset('images/plus_symbol.png') }}" alt="Zväčšiť množstvo" class="w-3">
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="font-semibold py-2 px-15 border mt-2 mb-4 rounded-xl bg-white text-black hover:bg-gray-100">
                            Pridať do košíka
                        </button>
                    </form>
                    <script>
                        function incrementQuantity() {
                            const input = document.getElementById('quantity_input');
                            input.value = parseInt(input.value) + 1;
                        }
                        function decrementQuantity() {
                            const input = document.getElementById('quantity_input');
                            if (parseInt(input.value) > 1) {
                                input.value = parseInt(input.value) - 1;
                            }
                        }

                        function setMainProductImage(imageSrc, isGrayscale, clickedButton) {
                            const mainImage = document.getElementById('main_product_image');
                            if (mainImage) {
                                mainImage.src = imageSrc;
                                if (isGrayscale) {
                                    mainImage.classList.add('grayscale');
                                } else {
                                    mainImage.classList.remove('grayscale');
                                }
                            }

                            document.querySelectorAll('.product-thumb-btn').forEach((button) => {
                                button.classList.remove('border-gray-900');
                                button.classList.add('border-transparent');
                            });

                            clickedButton.classList.remove('border-transparent');
                            clickedButton.classList.add('border-gray-900');
                        }
                    </script>
                </div>
            </div>
            
            <div class="flex flex-col gap-6 mx-2 m-7 mb-10">                
                <div class="flex flex-col px-4 gap-10 lg:flex-row lg:gap-20 items-center">
                    <div class="flex flex-col w-full lg:w-1/2 gap-y-2 lg:gap-y-3 text-lg">
                        <span class="flex font-semibold justify-center mb-2 items-center">Parametre produktu</span>
                    
                        <div class="flex p-4 rounded-xl bg-gray-100">
                            <span class="font-bold px-2">Značka</span>
                            <span class="flex flex-1 justify-end pr-2">{{ $product->znacka->nazov }}</span>
                        </div>

                        <div class="flex p-4 rounded-xl bg-gray-100">
                            <span class="font-bold px-2">Kategória</span>
                            <span class="flex flex-1 justify-end pr-2">{{ $product->kategoria->nazov }}</span>
                        </div>

                        <div class="flex p-4 rounded-xl bg-gray-100">
                            <span class="font-bold px-2">Materiál</span>
                            <span class="flex flex-1 justify-end pr-2">Bavlna / Polyester</span>
                        </div>

                        <div class="flex p-4 rounded-xl bg-gray-100">
                            <span class="font-bold px-2">Farba</span>
                            <span class="flex flex-1 justify-end pr-2">Rôzne</span>
                        </div>

                        <div class="flex p-4 rounded-xl bg-gray-100">
                            <span class="font-bold px-2">Sezóna</span>
                            <span class="flex flex-1 justify-end pr-2">Celoročné</span>
                        </div>
                    </div>

                    <div class="w-full mt-10 h-[0.5px] lg:hidden bg-gray-500"></div>

                    <div class="flex flex-col w-full lg:w-1/2 lg:gap-y-3 text-lg">
                        <span class="flex font-semibold justify-center mb-2 items-center">Čo hovoria na tento produkt ľudia?</span>
                        <!-- Recenzie ostávajú statické podľa zadania zachovania dizajnu -->
                        <div class="flex flex-col items-center gap-x-4 gap-y-6 p-2 rounded-xl">
                            <div class="flex gap-x-4 w-full items-center">
                                <div class="flex flex-col items-center mt-1">
                                    <img src="{{ asset('images/star.png') }}" alt="ikona hodnotenia" class="w-7">
                                    <span class="text-xs">4.5/5</span>
                                </div>
                                <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                                <div class="flex flex-col flex-1">
                                    <span class="text-sm font-bold">Jozef N.</span>
                                    <div class="h-4 mt-1.5 rounded-xl mb-1 bg-gray-200 "></div>
                                </div>
                            </div>
                            <!-- ... ďalšie recenzie ... -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden items-center lg:flex md:w-[5%]"></div>
    </main>
@endsection
