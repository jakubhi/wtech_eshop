@if ($paginator->hasPages())
    <nav class="flex justify-center gap-x-1 mt-10 mb-5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="flex items-center p-2 mr-3 rounded-lg border bg-white border-gray-300 cursor-not-allowed opacity-50">
                <img src="{{ asset('images/arrow.png') }}" alt="Predchádzajúca strana" class="h-4 w-4 rotate-90"> 
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center p-2 mr-3 rounded-lg border bg-white border-gray-300 hover:bg-gray-100 active:bg-gray-100">
                <img src="{{ asset('images/arrow.png') }}" alt="Predchádzajúca strana" class="h-4 w-4 rotate-90"> 
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-black rounded-lg border border-gray-400 cursor-default">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 font-bold text-white rounded-lg border bg-gray-500 border-gray-400 cursor-default">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-black rounded-lg border border-gray-400 hover:bg-gray-100 active:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center p-2 ml-3 rounded-lg border bg-white border-gray-300 hover:bg-gray-100 active:bg-gray-100">
                <img src="{{ asset('images/arrow.png') }}" alt="Ďalšia stránka" class="h-4 w-4 rotate-270">
            </a>
        @else
            <span class="flex items-center p-2 ml-3 rounded-lg border bg-white border-gray-300 cursor-not-allowed opacity-50">
                <img src="{{ asset('images/arrow.png') }}" alt="Ďalšia stránka" class="h-4 w-4 rotate-270">
            </span>
        @endif
    </nav>
@endif
