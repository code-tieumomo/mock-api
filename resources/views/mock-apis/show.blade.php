@extends('layouts.app')

@section('title', $mockApi->name . ' - Mock API')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.1.3/jsoneditor.min.css" />
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl">
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
            <h2 class="font-semibold mt-8 text-lg">Data</h2>
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
            <div id="jsoneditor" class="w-full min-h-96 h-[calc(100dvh-23rem)] mt-2"></div>
            <textarea name="storage" id="storage" class="hidden"></textarea>

            <div class="flex items-center justify-center gap-4 mt-4">
                <button class="btn bg-black text-white">
                    Save data
                </button>
            </div>
        </form>

        <h2 class="mt-8 font-semibold text-lg">
            Endpoints
        </h2>

        <section class="mt-4">
            <div class="border border-info text-info bg-info/10 p-2 rounded-md flex items-center gap-2">
                <span class="w-fit inline-flex overflow-hidden rounded-radius border border-info bg-info text-xs font-medium text-white">
                    <span class="flex items-center gap-1 bg-info/10 px-2 py-1">
                        <span class="size-1.5 rounded-full bg-white"></span>
                        GET
                    </span>
                </span>
                <span class="font-medium">
                    {{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}
                </span>
            </div>

            <h3 class="mt-4 font-semibold flex items-center gap-2">
                <div class="w-2 h-4 bg-info"></div>
                Get list of resources
            </h3>

            <h4 class="mt-4 text-sm">Params</h4>
            <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline mt-2">
                <table class="w-full text-left text-sm text-on-surface">
                    <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong">
                        <tr class="rounded-t">
                            <th scope="col" class="p-4">Name</th>
                            <th scope="col" class="p-4">Example</th>
                            <th scope="col" class="p-4">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline">
                        <tr>
                            <td class="p-4 font-bold">page</td>
                            <td class="p-4">[number] 1, 2, 3, ...</td>
                            <td class="p-4">The page number. Default is 1</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-bold">per_page</td>
                            <td class="p-4">[number] 10, 20, 50, ...</td>
                            <td class="p-4">The number of items per page. Default is 10</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-bold">query</td>
                            <td class="p-4">[string] john, doe, ...</td>
                            <td class="p-4">
                                The search query
                                <br>
                                Based on the query_field:
                                <ul class="list-disc pl-5">
                                    <li>If query_field has value, the query will search in that field</li>
                                    <li>If query_field is empty, the query will search in all fields</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 font-bold">query_field</td>
                            <td class="p-4">[string] name, address.city, users.0.email, ...</td>
                            <td class="p-4">The field to search</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h4 class="mt-4 text-sm">Example</h4>
            <div class="w-full divide-y divide-outline overflow-hidden rounded-radius border border-outline bg-surface-alt/40 text-on-surface dark:divide-outline-dark dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark mt-2">
                <div x-data="{ isExpanded: false }">
                    <button id="controlsAccordionItemOne" type="button" class="flex w-full items-center justify-between gap-4 bg-surface-alt px-4 py-2 text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden dark:bg-surface-dark-alt dark:hover:bg-surface-dark-alt/75 dark:focus-visible:bg-surface-dark-alt/75" aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded" x-bind:class="isExpanded ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold'  : 'text-on-surface dark:text-on-surface-dark font-medium'" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                        Get all resources
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                        <div class="px-4 py-2 text-sm sm:text-base text-pretty">
                            <a href="{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}" target="_blank" class="flex items-center">
                                <span class="text-info mr-4">GET</span>
                                <span class="font-semibold">{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}</span>
                                <span class="text-gray-500"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div x-data="{ isExpanded: false }">
                    <button id="controlsAccordionItemOne" type="button" class="flex w-full items-center justify-between gap-4 bg-surface-alt px-4 py-2 text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden dark:bg-surface-dark-alt dark:hover:bg-surface-dark-alt/75 dark:focus-visible:bg-surface-dark-alt/75" aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded" x-bind:class="isExpanded ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold'  : 'text-on-surface dark:text-on-surface-dark font-medium'" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                        Get all resources in page 2 with 5 items per page
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                        <div class="px-4 py-2 text-sm sm:text-base text-pretty">
                            <a href="{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}?page=2&per_page=5" target="_blank" class="flex items-center">
                                <span class="text-info mr-4">GET</span>
                                <span class="font-semibold">{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}</span>
                                <span class="text-gray-500">?page=2&per_page=5</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div x-data="{ isExpanded: false }">
                    <button id="controlsAccordionItemOne" type="button" class="flex w-full items-center justify-between gap-4 bg-surface-alt px-4 py-2 text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden dark:bg-surface-dark-alt dark:hover:bg-surface-dark-alt/75 dark:focus-visible:bg-surface-dark-alt/75" aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded" x-bind:class="isExpanded ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold'  : 'text-on-surface dark:text-on-surface-dark font-medium'" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                        Get all resources that contain "john" in any field
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                        <div class="px-4 py-2 text-sm sm:text-base text-pretty">
                            <a href="{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}?query=john" target="_blank" class="flex items-center">
                                <span class="text-info mr-4">GET</span>
                                <span class="font-semibold">{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}</span>
                                <span class="text-gray-500">?query=john</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div x-data="{ isExpanded: false }">
                    <button id="controlsAccordionItemOne" type="button" class="flex w-full items-center justify-between gap-4 bg-surface-alt px-4 py-2 text-left underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden dark:bg-surface-dark-alt dark:hover:bg-surface-dark-alt/75 dark:focus-visible:bg-surface-dark-alt/75" aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded" x-bind:class="isExpanded ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold'  : 'text-on-surface dark:text-on-surface-dark font-medium'" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                        Get all resources that contain "john" in "name" field
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                        <div class="px-4 py-2 text-sm sm:text-base text-pretty">
                            <a href="{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}?query=john&query_field=name" target="_blank" class="flex items-center">
                                <span class="text-info mr-4">GET</span>
                                <span class="font-semibold">{{ config('app.url') }}/api/{{ Auth::user()->provider_id }}{{ $mockApi->prefix }}</span>
                                <span class="text-gray-500">?query=john&query_field=name</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="my-8 border-t border-gray-300">
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
