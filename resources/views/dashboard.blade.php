@extends('layouts.app')

@section('title', 'Dashboard - Mock API')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="font-bold">
                APIs
            </h1>

            <a href="{{ route('mock-apis.create') }}">
                <button class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12 21q-.425 0-.712-.288T11 20v-7H4q-.425 0-.712-.288T3 12t.288-.712T4 11h7V4q0-.425.288-.712T12 3t.713.288T13 4v7h7q.425 0 .713.288T21 12t-.288.713T20 13h-7v7q0 .425-.288.713T12 21" />
                    </svg>
                    Create API
                </button>
            </a>
        </div>

        @if (session('success'))
            <div class="relative w-full overflow-hidden rounded-sm border border-green-500 bg-surface text-on-surface my-2" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                    <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-success">
                            {{ session('success') }}
                        </h3>
                    </div>
                    <button class="ml-auto" aria-label="dismiss alert" type="button" x-on:click="show = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @forelse($mockApis as $mockApi)
            <a href="{{ route('mock-apis.show', $mockApi) }}"
                class="flex items-center justify-between w-full border border-gray-300 rounded-md p-4 mt-4 hover:bg-gray-100">
                <div>
                    <h2 class="font-bold">{{ $mockApi->name }}</h2>
                    <p class="text-sm mt-2">
                        <span
                            class="rounded-radius w-fit border border-outline bg-surface-alt px-2 py-1 text-xs font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                            {{ $mockApi->prefix }}
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-1 text-gray-400 text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M4 14v-2h7v2zm0-4V8h11v2zm0-4V4h11v2zm9 14v-3.075l6.575-6.55l3.075 3.05L16.075 20zm6.575-5.6l.925-.975l-.925-.925l-.95.95z" />
                    </svg>
                    {{ $mockApi->updated_at->diffForHumans() }}
                </div>
            </a>
        @empty
            <p class="text-sm italic text-gray-500 mt-4">
                Not found any API, create one now.
            </p>
        @endforelse
    </div>
@endsection
