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
                        class="flex w-full items-center justify-between gap-4 bg-surface-alt p-4 text-sm text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden"
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
                    <div class="p-4 text-sm text-pretty grid grid-cols-2 gap-8">
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Resource Name<sup class="text-red-500">*</sup>
                            </label>
                            <input type="text" name="name" value="{{ $name }}" id="name" class="mt-1 input w-full" placeholder="Todo, User, ...">
                        </div>
            
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Resource Prefix<sup class="text-red-500">*</sup>
                            </label>
                            <input type="text" name="resource_prefix" value="{{ $resourcePrefix }}" id="resource-prefix" class="mt-1 input w-full" placeholder="/todos, /users, ...">
                        </div>

                        <div class="col-span-full">
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <div id="description-editor" class="element"></div>
                            <textarea name="description" id="description" class="hidden">
                                {{ $description }}
                            </textarea>
                            <p class="italic text-xs text-gray-500 mt-2">
                                For the best practice, you should provide a description for this API, include the purpose, the data
                                structure, and the response.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="italic text-sm text-gray-800 mt-8">
            Make sure the JSON structure below is correct with your expectation. If not, you can edit it.
        </p>
        <div id="jsoneditor" class="w-full h-96 mt-2"></div>
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

      const initialJson = @json($structure);
      editor.set(initialJson);
      // editor.expandAll(); // Only work in view mode

      const updatedJson = editor.get();
    </script>
@endsection
