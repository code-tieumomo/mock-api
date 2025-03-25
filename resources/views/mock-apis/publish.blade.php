@extends('layouts.app')

@section('title', 'Publish Mock API - Mock API')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.1.3/jsoneditor.min.css" />
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="font-bold">
                Publish Mock API
            </h1>
        </div>
        <div
            class="mt-8 w-full divide-y divide-outline overflow-hidden rounded-radius border border-outline bg-surface-alt/40 text-on-surface">
            <div x-data="{ isExpanded: true }">
                <button id="controlsAccordionItemOne" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-surface-alt p-4 text-sm text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden"
                    aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded"
                    x-bind:class="isExpanded ? 'text-on-surface-strong font-bold' : 'text-on-surface font-medium'"
                    x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                    Draft Data
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="isExpanded ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region"
                    aria-labelledby="controlsAccordionItemOne" x-collapse>
                    <form action="{{ route('mock-apis.regenerate', $mockApi) }}" class="p-4 text-sm text-pretty grid grid-cols-2 gap-8" method="POST">
                        @csrf

                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Resource Name
                            </label>
                            <input type="text" name="name" value="{{ $mockApi->name }}"
                                class="mt-1 input w-full" placeholder="Todo, User, ...">
                            @error('name')
                            <div class="mt-1 text-red-500 italic text-xs">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Resource Prefix
                            </label>
                            <input type="text" name="prefix" value="{{ $mockApi->prefix }}"
                                class="mt-1 input w-full" placeholder="/todos, /users, ...">
                            @error('prefix')
                            <div class="mt-1 text-red-500 italic text-xs">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-full">
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <div id="description-editor" class="element"></div>
                            <textarea name="description" id="description" class="hidden"></textarea>
                        </div>

                        <div class="col-span-full flex items-center justify-end gap-4">
                            <button class="btn bg-black text-white" type="submit">
                                Save and Generate new JSON structure
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <form id="form-publish" action="{{ route('mock-apis.publish.store', $mockApi) }}" method="POST">
            @csrf
            <p class="italic text-sm text-gray-800 mt-8">
                Make sure the JSON structure below is correct with your expectation. If not, you can edit it.
            </p>
            <div id="jsoneditor" class="w-full h-96 mt-2"></div>
            <textarea name="json_structure" id="json-structure" class="hidden"></textarea>
    
            <div class="flex items-center justify-center gap-4 mt-4">
                <a href="{{ route('mock-apis.create') }}">
                    <button class="btn" type="button">
                        Back to Create API
                    </button>
                </a>
                <button class="btn bg-black text-white">
                    Publish API
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

        const initialJson = @json($mockApi->structure);
        jsonEditor.set(initialJson);

        const formPublish = document.getElementById('form-publish');
        formPublish.addEventListener('submit', function (event) {
            event.preventDefault();
            const json = jsonEditor.get();
            document.getElementById('json-structure').value = JSON.stringify(json);
            formPublish.submit();
        });
    </script>

    <script type="module">
        import {
            Editor
        } from 'https://esm.sh/@tiptap/core';
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit';
        import Placeholder from 'https://esm.sh/@tiptap/extension-placeholder';

        const editor = new Editor({
            element: document.querySelector('.element'),
            extensions: [
                StarterKit,
                Placeholder.configure({
                    placeholder: 'Write something …',
                }),
            ],
            content: {!! $mockApi->description ? json_encode($mockApi->description) : "''" !!},
            onUpdate({ editor }) {
                document.querySelector('#description').value = editor.getHTML();
            },
        });
    </script>
@endsection
