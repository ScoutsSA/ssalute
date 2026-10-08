<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
                <div class="absolute inset-0 bg-neutral-900"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center gap-3 text-lg font-medium" wire:navigate>
                    <x-ssa.logo variant="on-purple" class="h-10 w-auto rounded-sm" />
                    {{ config('app.name', 'Laravel') }}
                </a>

                <div class="relative z-20 mt-auto text-sm text-neutral-300">
                    SCOUTS South Africa, <x-ssa.membership-line />
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-3 font-medium lg:hidden" wire:navigate>
                        <x-ssa.logo variant="on-purple" class="w-40 rounded-sm" />
                        <span class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    {{ $slot }}
                    <p class="text-center text-xs text-neutral-500 lg:hidden dark:text-neutral-400">
                        SCOUTS South Africa, <x-ssa.membership-line />
                    </p>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
