<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        @include('partials.header')
        {{ $slot }}

        @livewire('notifications')
        @fluxScripts
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
    <x-impersonate::banner/>
</html>
