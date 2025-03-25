@extends('layouts.app')

@section('title', $mockApi->name . ' - Mock API')

@section('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.1.3/jsoneditor.min.css"/>
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
            <span class="font-semibold">{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}</span>
        </div>

        <h2 class="font-semibold mt-8">Data</h2>
        <div id="jsoneditor" class="w-full h-96 mt-2"></div>
        <textarea name="storage" id="storage" class="hidden"></textarea>
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
    </script>
@endsection
