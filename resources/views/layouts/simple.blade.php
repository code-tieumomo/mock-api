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

<body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="flex items-center justify-center w-full lg:grow">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <div
                class="text-sm flex-1 p-6 pb-12 lg:p-12 bg-white shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                @yield('content')
            </div>
            <div
                class="bg-[#fff2f2] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
                <img src="{{ asset('assets/images/hero.jpg') }}" alt="hero" class="object-cover w-full h-full" />

                <div
                    class="absolute inset-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)]">
                </div>
            </div>
        </main>
    </div>

    @yield('js')
</body>

</html>
