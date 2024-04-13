<nav class="flex items-center justify-center py-3 px-6 border-b border-gray-100">
    <div id="nav-left" class="flex items-center">
        <div class="text-gray-800 font-semibold">
            <x-nav-link href="{{ route('posts.index') }}" :select-none="request()->routeIs('home')">
                <span class="main-logo text-3xl font-normal">Books Are Cool</span>
            </x-nav-link>
        </div>
        {{-- <div class="top-menu ml-10">
            <div class="flex space-x-4">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-nav-link>
                <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                    {{ __('Blog') }}
                </x-nav-link>
            </div> --}}
        </div>
    </div>
    {{-- <div id="nav-right" class="flex items-center md:space-x-6">
        @guest
            @include('layouts.partials.header-right-guest')
        @endguest

        @auth()
            @include('layouts.partials.header-right-auth')
        @endauth
    </div> --}}
</nav>