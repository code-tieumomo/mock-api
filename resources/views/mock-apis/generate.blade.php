@extends('layouts.app')

@section('title', 'Generate JSON Structure - Mock API')

@section('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.1.3/jsoneditor.min.css"/>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="font-bold">
                Generate JSON Structure
            </h1>
        </div>
        <div class="mt-8 w-full divide-y divide-outline overflow-hidden rounded-radius border border-outline bg-surface-alt/40 text-on-surface">
            <div x-data="{ isExpanded: false }">
                <button id="controlsAccordionItemOne" type="button"
                        class="flex w-full items-center justify-between gap-4 bg-surface-alt px-3 py-1.5 text-sm text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden"
                        aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded"
                        x-bind:class="isExpanded ? 'text-on-surface-strong font-bold'  : 'text-on-surface font-medium'"
                        x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                    Submitted Data
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                         stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                         x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region"
                     aria-labelledby="controlsAccordionItemOne" x-collapse>
                    <div class="px-3 py-2 text-sm text-pretty">
                        <ul class="list-disc pl-4">
                            <li>
                                <span class="font-medium">Resource Name: </span>
                                <span>{{ $name }}</span>
                            </li>
                            <li>
                                <span class="font-medium">Resource Prefix: </span>
                                <span>`{{ $resourcePrefix }}`</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <p class="italic text-sm text-gray-800 mt-8">
            Make sure the JSON structure below is correct with your expectation. If not, you can edit it.
        </p>
        <div id="jsoneditor" class="w-full h-96 mt-2"></div>

        <form action="">
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="resource_prefix" value="{{ $resourcePrefix }}">
            <input type="hidden" name="json_structure" id="json-structure">
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
        onModeChange: function (newMode, oldMode) {
          console.log('Mode switched from', oldMode, 'to', newMode)
        }
      };
      const editor = new JSONEditor(container, options);

      const initialJson = {
        'name': 'String',
        'age': 25,
        'isStudent': true,
        'address': {
          'street': 'Main Street',
          'city': 'New York'
        }
      };
      editor.set(initialJson);
      editor.expandAll();

      const updatedJson = editor.get();
    </script>
@endsection
