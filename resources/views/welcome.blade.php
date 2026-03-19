<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ssalute — Scouts South Africa</title>
    <meta name="description" content="Ssalute is the modern member management system for Scouts South Africa.">
    <link rel="icon" type="image/png" sizes="196x196" href="{{ asset('icons/favicon-196.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-icon-180.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    @php
        $authedUser = auth()->user();
        $panelUrl = '/general/login';
        if ($authedUser) {
            $tenant = $authedUser->getDefaultTenant(\Filament\Facades\Filament::getPanel('general'));
            $panelUrl = $tenant
                ? \Filament\Pages\Dashboard::getUrl(panel: 'general', tenant: $tenant)
                : '/general';
        }
    @endphp
    @vite(['resources/css/app.css'])
    <style>
        @keyframes float-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: float-in 0.6s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .delay-1 { animation-delay: 0.08s; }
        .delay-2 { animation-delay: 0.16s; }
        .delay-3 { animation-delay: 0.28s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.52s; }
    </style>
</head>
<body class="min-h-screen bg-[#1a0a2e] font-sans antialiased">

    {{-- Full-page purple gradient background --}}
    <div class="pointer-events-none fixed inset-0" aria-hidden="true">
        <div class="absolute inset-0 bg-gradient-to-b from-[#2a1248] via-[#1a0a2e] to-[#0f0620]"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 32px 32px;"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-3xl flex-col px-6">

        {{-- Nav --}}
        <nav class="animate-in flex items-center justify-between py-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Scouts South Africa" class="size-9 object-contain">
                <span class="text-lg font-bold text-white/90">Ssalute</span>
            </div>
            <a href="{{ $panelUrl }}"
               class="rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white/90 ring-1 ring-white/15 backdrop-blur-sm transition hover:bg-white/15 hover:ring-white/25">
                {{ $authedUser ? 'Go to Dashboard' : 'Sign in' }}
            </a>
        </nav>

        {{-- Hero --}}
        <main class="flex flex-1 flex-col justify-center pb-20">

            <div class="animate-in delay-1 mx-auto mb-10 flex size-20 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10">
                <img src="{{ asset('images/logo.png') }}" alt="" class="size-12 object-contain">
            </div>

            <h1 class="animate-in delay-2 text-center text-4xl font-bold tracking-tight text-white sm:text-5xl">
                @if ($authedUser)
                    Welcome back, {{ $authedUser->first_name }}
                @else
                    Welcome to Ssalute
                @endif
            </h1>

            <p class="animate-in delay-3 mx-auto mt-5 max-w-md text-center text-base leading-relaxed text-white/50">
                The modern member management system for Scouts South Africa, slowly replacing Scouts Digital over the next few years.
            </p>

            <div class="animate-in delay-3 mt-10 flex justify-center">
                <a href="{{ $panelUrl }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-7 py-3 text-sm font-semibold text-[#2a1248] shadow-lg shadow-black/20 transition hover:bg-zinc-100">
                    {{ $authedUser ? 'Go to your account' : 'Sign in to your account' }}
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>

            {{-- Cards --}}
            <div class="mt-20 grid gap-4 sm:grid-cols-2">
                <a href="https://join.slack.com/t/scoutssa/shared_invite/zt-3ss7zpgqa-UkqirUjoLRX9jd8R0lpu~w" target="_blank"
                   class="group rounded-xl bg-white/[0.06] p-6 ring-1 ring-white/10 transition hover:bg-white/[0.09] hover:ring-white/15">
                    <div class="mb-3 flex size-10 items-center justify-center rounded-lg bg-white/10">
                        <svg class="size-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                    </div>
                    <h2 class="font-semibold text-white/90">Contribute Your Time</h2>
                    <p class="mt-1.5 text-sm leading-relaxed text-white/40">
                        Join our Slack community to help break down features, share ideas, and follow our progress.
                    </p>
                    <span class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-purple-300 transition group-hover:text-purple-200">
                        Join the community
                        <svg class="size-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </span>
                </a>

                <a href="https://www.scoutfoundation.org.za/donate/#monthly-donation-options" target="_blank"
                   class="group rounded-xl bg-white/[0.06] p-6 ring-1 ring-white/10 transition hover:bg-white/[0.09] hover:ring-white/15">
                    <div class="mb-3 flex size-10 items-center justify-center rounded-lg bg-white/10">
                        <svg class="size-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                    </div>
                    <h2 class="font-semibold text-white/90">Support Financially</h2>
                    <p class="mt-1.5 text-sm leading-relaxed text-white/40">
                        Help cover infrastructure, security, and accessibility investments for youth and volunteers nationwide.
                    </p>
                    <span class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-purple-300 transition group-hover:text-purple-200">
                        Donate to Scouts SA
                        <svg class="size-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </span>
                </a>
            </div>

            {{-- Open source note --}}
            <div class="animate-in delay-5 mt-8 rounded-xl bg-white/[0.04] px-6 py-4 ring-1 ring-white/[0.06]">
                <p class="text-center text-sm leading-relaxed text-white/40">
                    <span class="text-white/60">Ssalute is fully open source</span> (MIT) and owned by Scouts South Africa. We are rolling out in phases, progressively migrating features and data.
                    Follow progress in the
                    <a href="https://join.slack.com/t/scoutssa/shared_invite/zt-3ss7zpgqa-UkqirUjoLRX9jd8R0lpu~w" target="_blank"
                       class="font-medium text-purple-300 underline decoration-purple-300/30 underline-offset-2 transition hover:decoration-purple-300/60">Slack Community</a>.
                </p>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-white/[0.06] py-6">
            <div class="flex flex-col items-center gap-2 sm:flex-row sm:justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="size-4 object-contain opacity-30">
                    <span class="text-xs text-white/25">Scouts South Africa</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="https://join.slack.com/t/scoutssa/shared_invite/zt-3ss7zpgqa-UkqirUjoLRX9jd8R0lpu~w" target="_blank"
                       class="text-xs text-white/25 transition hover:text-white/50">Slack</a>
                    <span class="text-white/10">&middot;</span>
                    <a href="https://www.scouts.org.za" target="_blank"
                       class="text-xs text-white/25 transition hover:text-white/50">scouts.org.za</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
