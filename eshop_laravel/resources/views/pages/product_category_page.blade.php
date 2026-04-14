@extends('layouts.app')

@section('title', 'Kategória | E-Shop')

@section('content')
    <main class="flex flex-col lg:flex-row grow">
        <!-- Side panel-->
        <form action="{{ route('products.index') }}" method="GET" id="filterForm" class="flex flex-col w-full lg:w-1/7 lg:mt-30 mx-auto items-center mt-5 lg:sticky lg:top-4 self-start">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="w-full flex flex-col items-center">
                <div class="w-full text-xl font-semibold text-center lg:text-left lg:pl-5 mb-3">Kategória</div>
                <div class="flex flex-col gap-2 pl-5 lg:w-full items-start text-left">
                    <label class="flex p-1 justify-start items-center lg:w-full rounded-x1 cursor-pointer">
                        <input type="radio" name="category_id" value="" 
                            class="hidden peer category-radio" 
                            onclick="toggleRadio(this)"
                            {{ !request('category_id') ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-400 peer-checked:bg-green-300 bg-gray-200 w-6 h-6 shrink-0"></div>
                        <span class="pl-2">Všetky kategórie</span>
                    </label>

                    @foreach($categories as $cat)
                    <label class="flex p-1 justify-start items-center lg:w-full rounded-x1 cursor-pointer">
                        <input type="radio" name="category_id" value="{{ $cat->id }}" 
                            class="hidden peer category-radio" 
                            onclick="toggleRadio(this)"
                            {{ request('category_id') == $cat->id ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-400 peer-checked:bg-green-300 bg-gray-200 w-6 h-6 shrink-0"></div>
                        <span class="pl-2">{{ $cat->nazov }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="w-full flex flex-col items-center mt-6">
                <div class="w-full text-xl font-semibold text-center lg:text-left lg:pl-5 mb-3">Dostupnosť</div>
                <div class="flex flex-col gap-2 pl-5 lg:w-full items-start text-left">
                    <label class="flex p-1 justify-start items-center lg:w-full rounded-x1 cursor-pointer">
                        <input type="checkbox" name="availability" value="in_stock" 
                            class="hidden peer" 
                            onchange="this.form.submit()"
                            {{ request('availability') == 'in_stock' ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-400 peer-checked:bg-green-300 bg-gray-200 w-6 h-6 shrink-0"></div>
                        <span class="pl-2">Skladom</span>
                    </label>

                    <label class="flex p-1 justify-start items-center lg:w-full rounded-x1 cursor-pointer">
                        <input type="checkbox" name="availability_order" value="order" 
                            class="hidden peer" 
                            onchange="this.form.submit()"
                            {{ request('availability_order') == 'order' ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-400 peer-checked:bg-green-300 bg-gray-200 w-6 h-6 shrink-0"></div>
                        <span class="pl-2">Objednávkou</span>
                    </label>

                    <label class="flex p-1 justify-start items-center lg:w-full rounded-x1 cursor-pointer">
                        <input type="checkbox" name="availability_store" value="store" 
                            class="hidden peer" 
                            onchange="this.form.submit()"
                            {{ request('availability_store') == 'store' ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-400 peer-checked:bg-green-300 bg-gray-200 w-6 h-6 shrink-0"></div>
                        <span class="pl-2">Na predajni</span>
                    </label>
                </div>
            </div>

            <div class="w-full flex flex-col items-center mt-6">
                <div class="w-full text-xl font-semibold text-center lg:text-left lg:pl-5 mb-3">Značka</div>
                <div class="flex flex-col pl-5 gap-2 lg:w-full items-start text-left">
                    @foreach($brands as $brand)
                    <label class="flex p-1 justify-start items-center lg:w-full rounded-x1 cursor-pointer">
                        <input type="checkbox" name="brand_id[]" value="{{ $brand->znacka_id }}" 
                            class="hidden peer" 
                            onchange="this.form.submit()"
                            {{ in_array($brand->znacka_id, (array)request('brand_id')) ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-400 peer-checked:bg-green-300 bg-gray-200 w-6 h-6 shrink-0"></div>
                        <span class="pl-2">{{ $brand->nazov }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Price filter (added because it was in the dynamic version and it's useful for the requirement) -->
            <div class="w-full flex flex-col items-center mt-6">
                <div class="w-full text-xl font-semibold text-center lg:text-left lg:pl-5 mb-3">Cena</div>
                <div class="flex flex-col gap-2 pl-5 lg:w-full items-start text-left">
                    <div class="flex flex-col gap-2">
                        <input type="number" name="price_from" value="{{ request('price_from') }}" placeholder="Od" class="w-20 p-1 border border-gray-400 rounded-lg bg-gray-200" onchange="this.form.submit()">
                        <input type="number" name="price_to" value="{{ request('price_to') }}" placeholder="Do" class="w-20 p-1 border border-gray-400 rounded-lg bg-gray-200" onchange="this.form.submit()">
                    </div>
                </div>
            </div>
        </form>

        <!--Middle -->
        <div class="flex flex-col grow ">
            <!--top middle-->
            <div class="flex font-semibold justify-center pt-10">
                <div class="flex justify-center w-4/5 flex-col">
                    <div class="font-semibold bg-gray-400 rounded-2xl flex justify-center">
                        {{ $categories->find(request('category_id'))->nazov ?? (request('search') ? 'Výsledky vyhľadávania' : 'Všetky produkty') }}
                    </div>
                    
                    <div class="bg-gray-200 border border-gray-300 rounded-2xl shadow-sm flex flex-col sm:flex-row sm:items-center gap-2 p-3 overflow-hidden">
                        <div class="w-8 h-8 hidden sm:flex bg-gray-300 rounded-full overflow-hidden shrink-0 items-center justify-center">
                            <img src="{{ asset('images/sort.png') }}" alt="product icon" class="w-5 h-5">
                        </div>
                        <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center w-full gap-2 md:gap-x-[5%] lg:gap-x-[8%] xl:gap-x-[10%]">
                            <div class="text-sm sm:text-base shrink-0">Zoradiť podľa:</div>

                            <label class="pr-2 flex rounded-xl border border-[#D9D9D9] cursor-pointer">
                                <input type="radio" name="sort" value="nazov_asc" class="hidden peer" form="filterForm" onchange="this.form.submit()" {{ request('sort', 'nazov_asc') == 'nazov_asc' ? 'checked' : '' }}>
                                <div class="w-6 h-6 rounded-xl peer-checked:bg-green-300 bg-gray-300"></div>
                                <span class="pl-2">Názov A-Z</span>
                            </label>

                            <label class="pr-2 flex rounded-xl border border-[#D9D9D9] cursor-pointer">
                                <input type="radio" name="sort" value="cena_asc" class="hidden peer" form="filterForm" onchange="this.form.submit()" {{ request('sort') == 'cena_asc' ? 'checked' : '' }}>
                                <div class="w-6 h-6 rounded-xl peer-checked:bg-green-300 bg-gray-300"></div>
                                <span class="pl-2">Cena vzostupne</span>
                            </label>

                            <label class="pr-2 flex rounded-xl border border-[#D9D9D9] cursor-pointer">
                                <input type="radio" name="sort" value="cena_desc" class="hidden peer" form="filterForm" onchange="this.form.submit()" {{ request('sort') == 'cena_desc' ? 'checked' : '' }}>
                                <div class="w-6 h-6 rounded-xl peer-checked:bg-green-300 bg-gray-300"></div>
                                <span class="pl-2">Cena zostupne</span>
                            </label>

                            <label class="pr-2 flex rounded-xl border border-[#D9D9D9] cursor-pointer">
                                <input type="radio" name="sort" value="nazov_desc" class="hidden peer" form="filterForm" onchange="this.form.submit()" {{ request('sort') == 'nazov_desc' ? 'checked' : '' }}>
                                <div class="w-6 h-6 rounded-xl peer-checked:bg-green-300 bg-gray-300"></div>
                                <span class="pl-2">Názov Z-A</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        
            <!--middle middle-->  
            <section class="grid grid-cols-1 justify-items-center items-stretch mb-10 sm:grid-cols-2 gap-5 px-4 md:grid-cols-3 xl:grid-cols-4 xl:gap-x-10 mt-4 lg:mt-8">
                @foreach($products as $product)
                    <div class="bg-[#c2c0c078] rounded-2xl mb-3 flex items-center justify-center hover:brightness-85 active:brightness-85">
                        <div class="flex flex-col bg-gray-300 rounded-lg overflow-hidden">
                            <a href="{{ route('products.show', $product->produkt_id) }}">
                                <img src="{{ $product->image_path }}" alt="{{ $product->nazov }}">
                            </a>
                            <span class="flex h-20 justify-center text-center text-black-500 font-bold text-2xl mb-2 mt-2 wrap-break-word">
                                {{ $product->nazov }}
                            </span>
                            <div class="flex justify-between mt-auto items-center">
                                <div class="flex flex-col">
                                    <span class="flex justify-left line-through items-center flex-1 text-gray-600 text-xl rounded-full ml-2 mr-2">
                                        {{ number_format($product->cena * 1.2, 2) }} €
                                    </span>
                                    <span class="flex justify-center flex-1 items-center text-black-500 text-3xl rounded-full mr-2">
                                        {{ number_format($product->cena, 2) }} €
                                    </span>
                                </div>
                                <form action="{{ route('cart.add', $product->produkt_id) }}" method="POST" class="mr-3">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-gray-300 hover:bg-gray-400 transition">
                                        <img src="{{ asset('images/cart.png') }}" class="w-12 object-contain">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        </div>

        <div class="hidden items-center lg:flex md:w-[5%]"></div>
    </main>

    <nav class="flex justify-center gap-x-1 mt-10 mb-5">
        {{ $products->links('vendor.pagination.eshop') }}
    </nav>

    <script>
        function toggleRadio(radio) {
            if (radio.getAttribute('data-was-checked') === 'true') {
                const allRadio = document.querySelector('.category-radio[value=""]');
                if (allRadio && radio !== allRadio) {
                    allRadio.checked = true;
                    document.querySelectorAll('.category-radio').forEach(r => r.setAttribute('data-was-checked', 'false'));
                    allRadio.setAttribute('data-was-checked', 'true');
                } else {
                    return;
                }
            } else {
                document.querySelectorAll('.category-radio').forEach(r => r.setAttribute('data-was-checked', 'false'));
                radio.setAttribute('data-was-checked', 'true');
            }
            radio.form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.category-radio').forEach(radio => {
                if (radio.checked) {
                    radio.setAttribute('data-was-checked', 'true');
                }
            });
        });
    </script>
@endsection
