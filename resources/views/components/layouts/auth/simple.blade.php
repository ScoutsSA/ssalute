<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center mb-2 gap-3 font-medium" wire:navigate>
                    <x-ssa.logo variant="on-purple" class="w-40 rounded-sm" />
                    <span class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
                <p class="text-center text-xs text-neutral-500 dark:text-neutral-400">
                    SCOUTS South Africa, <x-ssa.membership-line />
                </p>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
