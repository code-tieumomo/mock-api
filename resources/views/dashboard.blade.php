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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M12 21q-.425 0-.712-.288T11 20v-7H4q-.425 0-.712-.288T3 12t.288-.712T4 11h7V4q0-.425.288-.712T12 3t.713.288T13 4v7h7q.425 0 .713.288T21 12t-.288.713T20 13h-7v7q0 .425-.288.713T12 21"/></svg>
                    Create API
                </button>
            </a>
        </div>

        @forelse($mockApis as $mockApi)
            <a href="{{ route('mock-apis.show', $mockApi) }}" class="flex items-center justify-between w-full border border-gray-300 rounded-md p-4 mt-4 hover:bg-gray-100">
                <div>
                    <h2 class="font-bold">{{ $mockApi->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1 bg-gray-100 px-2 py-0.5 rounded-md shadow border border-gray-300">{{ $mockApi->prefix }}</p>
                </div>
                <div class="flex items-center gap-1 text-gray-400 text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M4 14v-2h7v2zm0-4V8h11v2zm0-4V4h11v2zm9 14v-3.075l6.575-6.55l3.075 3.05L16.075 20zm6.575-5.6l.925-.975l-.925-.925l-.95.95z"/></svg>
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
