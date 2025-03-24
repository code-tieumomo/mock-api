<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
            href="https://fonts.bunny.net/css?family=jetbrains-mono:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i"
            rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @yield('css')
    @vite(['resources/css/app.css'])

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">
<header class="border-b border-gray-300">
    <div class="flex items-center justify-between h-12 container mx-auto px-4">
        <div>
            <a href="{{ route('dashboard') }}" class="font-semibold flex items-center gap-2">
                <img src="{{ asset('favicon.png') }}" alt="logo" class="size-6">
                Mock API
            </a>
        </div>

        <div class="relative cursor-pointer" x-data="{
                showDropdown: false
            }">
            <div class="flex items-center gap-2" x-on:click="showDropdown = !showDropdown">
                    <span class="text-sm">
                        {{ Auth::user()->name }}
                    </span>
                <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-6 rounded-full ring-2 ring-gray-400">
            </div>

            <div x-show="showDropdown" x-transition style="display: none"
                 class="bg-white text-sm border border-gray-300 rounded-md absolute top-7 right-0 shadow-sm"
                 x-on:click.outside="showDropdown = false">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-1.5 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<main class="grow px-4">
    @yield('content')
</main>

<footer class="container mx-auto text-center text-xs py-2 px-4">
    Created by <a href="https://github.com/code-tieumomo" target="_blank"
                  class="text-[#1b1b18] font-semibold">quanph</a>.
    All rights reserved &copy; {{ date('Y') }}.
</footer>

<div id="overlay" class="w-screen h-screen fixed z-50 flex items-center justify-center bg-black/30 hidden">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
        <path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
              opacity=".25"/>
        <path fill="currentColor"
              d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z">
            <animateTransform attributeName="transform" dur="0.75s" repeatCount="indefinite" type="rotate"
                              values="0 12 12;360 12 12"/>
        </path>
    </svg>
</div>

<script>
  const overlayEl = document.querySelector('#overlay');

  const showOverlay = () => {
    overlayEl.classList.remove('hidden');
  };

  const hideOverlay = () => {
    overlayEl.classList.add('hidden');
  };
</script>
@yield('js')
</body>

</html>
