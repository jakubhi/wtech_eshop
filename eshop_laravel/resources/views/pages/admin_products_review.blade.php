@extends('layouts.app')

@section('title', 'Prehľad produktov | Admin')

@section('content')
<main class="flex flex-col lg:flex-row grow">
    <div class="hidden lg:flex lg:w-[10%]"></div>

    <div class="flex flex-col justify-center flex-1">
        <div class="p-3 bg-gray-400 rounded-lg text-center mb-10 font-bold mt-6 mx-4">
            <h1 class="text-xl">Prehľad produktov</h1>
        </div>

        <div class="bg-white text-black grid grid-cols-1 justify-items-center items-start h-full mb-10 sm:grid-cols-2 gap-5 px-4 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 xl:gap-x-10">
            @forelse($products as $p)
                <div class="bg-[#c2c0c078] rounded-2xl mb-3 flex items-center justify-center hover:brightness-85 active:brightness-85">
                    <div class="flex flex-col bg-gray-300 rounded-lg overflow-hidden">
                        <img src="{{ $p->image_path }}" alt="{{ $p->nazov }}">
                        <span class="flex h-20 justify-center text-center text-black-500 font-bold text-2xl mb-2 mt-2 wrap-break-word">
                           {{ $p->nazov }}
                        </span>
                        <div class="flex justify-between mt-auto items-center">
                            <div class="flex flex-col">
                                <span class="flex justify-left line-through items-center flex-1 text-gray-600 text-xl rounded-full ml-2 mr-2">
                                    {{ number_format($p->cena * 1.2, 2) }} €
                                </span>
                                <span class="flex justify-center flex-1 items-center text-black-500 text-3xl rounded-full mr-2">
                                    {{ number_format($p->cena, 2) }} €
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 p-2 pt-3">
                            <a href="/edit_product" class="border rounded-xl border-gray-200 bg-gray-300 p-2 text-center hover:bg-gray-400 transition font-semibold block w-full">Upraviť</a>
                            <form action="{{ route('admin.products.destroy', $p->produkt_id) }}" method="POST" onsubmit="return confirm('Naozaj chcete vymazať produkt?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border rounded-xl border-gray-200 bg-red-500 text-white p-2 text-center hover:bg-red-600 transition font-semibold w-full">Vymazať</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-600 text-lg py-10">
                    Nenašli sa žiadne produkty.
                </div>
            @endforelse
        </div>

        <div class="mt-2 mb-6">
            {{ $products->links('vendor.pagination.eshop') }}
        </div>
    </div>

    <div class="hidden lg:flex md:w-[5%]"></div>
</main>
@endsection
