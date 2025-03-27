@extends('layouts.simple')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-4xl font-bold">403</h1>
                <h2 class="mt-4 text-3xl">Forbidden</h2>
                <p class="mt-8 text-base">
                    {{ $exception->getMessage() ?: 'You are not authorized to access this page.' }}
                </p>

                <a href="{{ route('dashboard') }}" class="block mt-8">
                    <button class="btn bg-primary text-white">
                        Back to Dashboard
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
