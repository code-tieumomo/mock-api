@extends('layouts.app')

@section('title', 'Create - Mock API')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="font-bold">
                Create new API
            </h1>
        </div>

        <form id="form" action="{{ route('mock-apis.generate') }}" class="mt-4 grid grid-cols-2 gap-8" method="POST">
            @csrf

            <div class="col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Resource Name<sup class="text-red-500">*</sup>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" id="name" class="mt-1 input w-full"
                       placeholder="Todo, User, ...">
                @error('name')
                <div class="mt-1 text-red-500 italic text-xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Resource Prefix<sup class="text-red-500">*</sup>
                </label>
                <input type="text" name="prefix" value="{{ old('prefix') }}" id="resource-prefix"
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
                <p class="italic text-xs text-gray-500 mt-2">
                    For the best practice, you should provide a description for this API, include the purpose, the data
                    structure, and the response.
                </p>
            </div>

            <div class="col-span-full flex items-center justify-center gap-4">
                <button class="btn bg-black text-white" type="submit">
                    Generate JSON structure
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script type="module">
      import { Editor } from 'https://esm.sh/@tiptap/core';
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
        content: {!! old('description') ? json_encode(old('description')) : "''" !!},
      });

      const form = document.querySelector('#form');
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        setTimeout(() => showOverlay(), 100);
        document.querySelector('#description').value = editor.getHTML();
        form.submit();
      });
    </script>
@endsection