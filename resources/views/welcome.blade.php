@extends('layouts.simple')

@section('title', 'Mock API')

@section('content')
    <h1 class="mb-1 font-medium">Let's get started</h1>
    <p class="mb-2 text-[#706f6c]">
        Create your simple mock API for testing and prototyping in 2 steps
    </p>
    <ul class="flex flex-col mb-4 lg:mb-6">
        <li
            class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] before:top-1/2 before:bottom-0 before:left-[0.4rem] before:absolute">
            <span class="relative py-1 bg-white">
                <span
                    class="flex items-center justify-center rounded-full bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border border-[#e3e3e0]">
                    <span class="rounded-full bg-[#dbdbd7] w-1.5 h-1.5"></span>
                </span>
            </span>
            <span>
                Describe your API with natural language
            </span>
        </li>
        <li
            class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] before:bottom-1/2 before:top-0 before:left-[0.4rem] before:absolute">
            <span class="relative py-1 bg-white">
                <span
                    class="flex items-center justify-center rounded-full bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border border-[#e3e3e0]">
                    <span class="rounded-full bg-[#dbdbd7] w-1.5 h-1.5"></span>
                </span>
            </span>
            <span>
                Edit generated JSON structure of your API
            </span>
        </li>
    </ul>
    <ul class="flex gap-3 text-sm leading-normal">
        <li>
            <a href="{{ url('dashboard') }}"
                class="inline-block hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
                Get started
            </a>
        </li>
    </ul>
@endsection
