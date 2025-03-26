@extends('layouts.app')

@section('title', $mockApi->name . ' - Mock API')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.1.3/jsoneditor.min.css" />
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="font-bold">
                {{ $mockApi->name }}
            </h1>
        </div>

        <div class="mt-8 border border-gray-300 rounded-md p-4 text-sm">
            API Endpoint:
            <a href="{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}" target="_blank"
                class="font-semibold">
                {{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}
            </a>
        </div>

        <form id="form" action="{{ route('mock-apis.update', $mockApi) }}" method="POST">
            @method('PUT')
            @csrf
            <h2 class="font-semibold mt-8">Data</h2>
            @if (session('success'))
            <div class="relative w-full overflow-hidden rounded-sm border border-green-500 bg-surface text-on-surface my-2" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                    <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-success">Saved new data</h3>
                    </div>
                    <button class="ml-auto" aria-label="dismiss alert" type="button" x-on:click="show = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endif
            <div id="jsoneditor" class="w-full h-96 mt-2"></div>
            <textarea name="storage" id="storage" class="hidden"></textarea>

            <div class="flex items-center justify-center gap-4 mt-4">
                <button class="btn bg-black text-white">
                    Save data
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.1.3/jsoneditor.min.js"></script>
    <script>
        const container = document.getElementById('jsoneditor');
        const options = {
            mode: 'code',
            modes: ['code', 'view', 'preview'],
        };
        const jsonEditor = new JSONEditor(container, options);

        const initialJson = @json($mockApi->storage);
        jsonEditor.set(initialJson);

        const form = document.getElementById('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const json = jsonEditor.get();
            document.getElementById('storage').value = JSON.stringify(json);
            form.submit();
        });
    </script>
@endsection
