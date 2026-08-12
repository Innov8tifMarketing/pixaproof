@extends('layouts.base')

@section('body')
    <div class="flex min-h-screen flex-col bg-white">
        <x-navbar />

        <main class="flex-1 pt-16">
            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset
        </main>

        <x-footer />
    </div>
@endsection
