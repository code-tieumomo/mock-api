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
        rel="stylesheet" />

    <!-- Styles / Scripts -->
    @yield('css')
    @vite(['resources/css/app.css'])
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

            <div>
                <div class="flex items-center gap-2">
                    <span class="text-sm">
                        {{ Auth::user()->name }}
                    </span>
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-6 rounded-full ring-2 ring-gray-400">
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

    @yield('js')
</body>

</html>
