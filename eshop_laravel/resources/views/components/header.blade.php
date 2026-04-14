<header class="bg-black flex justify-between items-center flex-row text-md p-1 lg:pr-4">
    <a href="/">
        <div class="hidden items-center justify-center bg-[#2D2D2D] text-white border border-gray-200 rounded-full font-bold
            md:flex md:ml-1 md:px-3 md:py-2 md:mr-1
            lg:ml-3 lg:px-10
        ">
            ToJa Clothes
        </div>
    </a>
    
    <a href="/" class="flex md:hidden invert hover:opacity-80">
        <img src="{{ asset('images/home.png') }}" alt="Domov" class="w-10 p-1">
    </a>

    <div class="flex flex-1 justify-center px-4">  
        <form action="{{ route('products.index') }}" method="GET" class="relative w-full sm:max-w-md md:max-w-2xl lg:max-w-lg xl:max-w-4xl">
            <div class="flex items-center absolute inset-y-0 pl-2 sm:pl-4 md:pl-5 p-1">
                <button type="submit">
                    <img src="{{ asset('images/lupa.png') }}" alt="Vyhladat" class="w-5 h-5 sm:w-6 sm:h-6">
                </button>
            </div>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Hľadáte niečo?" class="bg-[#2D2D2D] text-white text-center rounded-full 
                border p-1 ml-1 mr-3 w-full sm:max-w-md md:max-w-xl lg:p-2 lg:m-1.5 lg:max-w-lg xl:max-w-4xl 
            ">
        </form>
    </div>
    
    <div class="flex items-center justify-between">
        @auth
            <div class="bg-[#2D2D2D] border border-white text-white
                hidden text-xs rounded-full
                sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-2 sm:p-1
                md:text-lg
            ">
                {{ Auth::user()->login }}
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 border border-white text-white
                    hidden text-xs rounded-full
                    sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-2 sm:p-1
                    md:text-lg
                    hover:brightness-85 active:brightness-85">
                        Odhlásiť
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-[#2D2D2D] border border-white text-white
                hidden text-xs rounded-full
                sm:flex sm:text-base sm:mr-3 sm:pl-3 sm:pr-2 sm:p-1
                md:text-lg
                hover:brightness-85 active:brightness-85">
                    Hosť - Login
            </a>
        @endauth

        <a href="{{ Auth::check() ? (Auth::user()->rola === 'admin' ? url('/admin_dashboard') : url('/login')) : route('login') }}">
            <img src="{{ asset('images/user.png') }}" alt="profile" class="h-10 pr-2 invert hover:opacity-80">
        </a>
        <a href="{{ route('cart.index') }}">
            <img src="{{ asset('images/cart.png') }}" alt="cart" class="h-10 pr-2 invert hover:opacity-80">
        </a>
        
        <span class="flex items-center pr-3 pl-1 text-white sm:text-lg lg:text-xl xl:text-2xl">
            {{ number_format($cartTotal, 2) }} €
        </span>
    </div>
</header>
