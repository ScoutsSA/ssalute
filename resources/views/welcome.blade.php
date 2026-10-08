<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ssalute, SCOUTS South Africa</title>
    <meta name="description" content="Ssalute is the modern member management system for SCOUTS South Africa.">
    <link rel="icon" type="image/png" sizes="196x196" href="{{ asset('icons/favicon-196.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-icon-180.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @php
        $authedUser = auth()->user();
        $panelUrl = '/holding-zone/login';
        if ($authedUser) {
            $tenant = $authedUser->getDefaultTenant(\Filament\Facades\Filament::getPanel('member'));
            $panelUrl = $tenant
                ? \Filament\Pages\Dashboard::getUrl(panel: 'member', tenant: $tenant)
                : '/holding-zone';
        }
        $slackUrl = 'https://join.slack.com/t/scoutssa/shared_invite/zt-3ss7zpgqa-UkqirUjoLRX9jd8R0lpu~w';
    @endphp
    @fluxAppearance
    @vite(['resources/css/app.css'])
    <style>
        @keyframes float-in {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: float-in 0.6s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .delay-1 { animation-delay: 0.08s; }
        .delay-2 { animation-delay: 0.16s; }
        .delay-3 { animation-delay: 0.28s; }
        .delay-4 { animation-delay: 0.4s; }
        @media (prefers-reduced-motion: reduce) {
            .animate-in { animation: none; }
        }
    </style>
</head>
<body class="min-h-screen bg-white font-sans text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">

    {{-- Brand band: flat SSA purple, the one place on this page the organisation signs --}}
    <header class="bg-[#622599] text-white">
        <div class="mx-auto flex max-w-3xl flex-col px-6">
            <nav class="animate-in flex items-center justify-between gap-4 py-6">
                <a href="https://www.scouts.org.za" target="_blank" rel="noopener" class="shrink-0">
                    <x-ssa.logo variant="on-purple" class="w-36 sm:w-40" />
                </a>
                <a href="{{ $panelUrl }}"
                   class="rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/30 transition hover:bg-white/15 hover:ring-white/50">
                    {{ $authedUser ? 'Go to Dashboard' : 'Sign in' }}
                </a>
            </nav>

            <div class="pb-14 pt-8 sm:pb-16 sm:pt-10">
                <div class="animate-in delay-1 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="size-8 object-contain">
                    <span class="text-lg font-bold tracking-tight">Ssalute</span>
                </div>

                <h1 class="animate-in delay-2 mt-5 text-4xl font-bold tracking-tight text-white sm:text-5xl">
                    @if ($authedUser)
                        Welcome back, {{ $authedUser->first_name }}
                    @else
                        Welcome to Ssalute
                    @endif
                </h1>

                <p class="animate-in delay-3 mt-5 max-w-lg text-base leading-relaxed text-white/80">
                    The modern member management system for SCOUTS South Africa, slowly replacing Scouts Digital over the next few years.
                </p>

                <div class="animate-in delay-3 mt-8">
                    <a href="{{ $panelUrl }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-[#622599] shadow-lg shadow-black/10 transition hover:bg-zinc-100">
                        {{ $authedUser ? 'Go to your account' : 'Sign in to your account' }}
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto flex max-w-3xl flex-col px-6">

        {{-- Cards --}}
        <div class="animate-in delay-4 mt-10 grid gap-4 sm:grid-cols-2">
            <a href="{{ $slackUrl }}" target="_blank" rel="noopener"
               class="group rounded-xl border border-zinc-200 bg-white p-6 transition hover:border-[#622599]/40 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-[#7B4DB8]/60">
                <div class="mb-3 flex size-10 items-center justify-center rounded-lg bg-[#F3EEFA] text-[#622599] dark:bg-[#7B4DB8]/15 dark:text-[#B48AE0]">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                </div>
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Contribute your time</h2>
                <p class="mt-1.5 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                    Join our Slack community to help break down features, share ideas, and follow our progress.
                </p>
                <span class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-[#622599] dark:text-[#B48AE0]">
                    Join the community
                    <svg class="size-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </span>
            </a>

            <a href="https://www.scoutfoundation.org.za/donate/#monthly-donation-options" target="_blank" rel="noopener"
               class="group rounded-xl border border-zinc-200 bg-white p-6 transition hover:border-[#622599]/40 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-[#7B4DB8]/60">
                <div class="mb-3 flex size-10 items-center justify-center rounded-lg bg-[#F3EEFA] text-[#622599] dark:bg-[#7B4DB8]/15 dark:text-[#B48AE0]">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                </div>
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Support financially</h2>
                <p class="mt-1.5 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                    Help cover infrastructure, security, and accessibility investments for youth and volunteers nationwide.
                </p>
                <span class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-[#622599] dark:text-[#B48AE0]">
                    Donate to SCOUTS South Africa
                    <svg class="size-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </span>
            </a>
        </div>

        {{-- Open source note --}}
        <div class="animate-in delay-4 mt-6 rounded-xl bg-[#F3EEFA] px-6 py-4 dark:border dark:border-zinc-800 dark:bg-zinc-900">
            <p class="text-center text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                <span class="font-medium text-zinc-900 dark:text-zinc-100">Ssalute is fully open source</span> (MIT) and owned by SCOUTS South Africa. We are rolling out in phases, progressively migrating features and data.
                Follow progress in the
                <a href="{{ $slackUrl }}" target="_blank" rel="noopener"
                   class="font-medium text-[#622599] underline decoration-[#622599]/30 underline-offset-2 transition hover:decoration-[#622599]/70 dark:text-[#B48AE0] dark:decoration-[#B48AE0]/30 dark:hover:decoration-[#B48AE0]/70">Slack community</a>.
            </p>
        </div>

        {{-- Footer --}}
        <footer class="mt-12 border-t border-zinc-200 py-6 dark:border-zinc-800">
            <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:justify-between sm:text-left">
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    SCOUTS South Africa, <x-ssa.membership-line />
                </p>
                <div class="flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400">
                    <a href="{{ $slackUrl }}" target="_blank" rel="noopener" class="transition hover:text-zinc-900 dark:hover:text-zinc-100">Slack</a>
                    <span class="text-zinc-300 dark:text-zinc-700">&middot;</span>
                    <a href="https://www.scouts.org.za" target="_blank" rel="noopener" class="transition hover:text-zinc-900 dark:hover:text-zinc-100">scouts.org.za</a>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
