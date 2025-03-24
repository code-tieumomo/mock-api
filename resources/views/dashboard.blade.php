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

        <p class="text-sm italic text-gray-500 mt-4">
            Not found any API, create one now.
        </p>
    </div>
@endsection
