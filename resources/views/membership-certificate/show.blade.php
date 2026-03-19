<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $metaTitle = $user->name . ' — Membership Certificate';
        $metaDescription = $isActiveMember
            ? 'Verified active member of Scouts South Africa — ' . $user->name . '. View this certificate to confirm membership status.'
            : $user->name . ' is no longer an active member of Scouts South Africa. This certificate is no longer valid.';
        $metaUrl = route('membership-certificate.show', $certificate->uuid);
        $metaImage = $photoUrl ?: asset('images/logo_padded.png');
    @endphp

    <title>{{ $metaTitle }} — Scouts South Africa</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:site_name" content="Scouts South Africa — Ssalute">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $photoUrl ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    @vite(['resources/css/app.css'])
    <script>
        (function() {
            const stored = localStorage.getItem('cert-theme');
            function apply(theme) {
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            apply(stored || 'system');
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const current = localStorage.getItem('cert-theme') || 'system';
                if (current === 'system') apply('system');
            });
        })();
    </script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; color-scheme: light !important; }
            .certificate-outer { box-shadow: none !important; margin: 0 !important; border-radius: 0 !important; }
            .print-header { padding-top: 1.25rem !important; padding-bottom: 1.25rem !important; }
            .print-header-logo { width: 2.5rem !important; height: 2.5rem !important; margin-bottom: 0.5rem !important; }
            .print-header-logo img { width: 1.5rem !important; height: 1.5rem !important; }
            .print-header h1 { font-size: 1.25rem !important; margin-top: 0.25rem !important; }
            .print-header .header-divider { display: none !important; }
            .print-body { padding: 1.25rem 2rem !important; }
            .print-stamp-wrap { margin-top: 1.5rem !important; }
            .print-stamp { width: 8rem !important; height: 8rem !important; }
            .print-stamp-inner { width: 6.5rem !important; height: 6.5rem !important; }
            .print-footer { padding: 0.75rem 2rem !important; }
            .print-qr { width: 3.5rem !important; height: 3.5rem !important; }
        }
        @page {
            size: A4;
            margin: 10mm;
            margin-top: 0;
            margin-bottom: 0;
        }
        .stamp {
            animation: stamp-in 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
        }
        @keyframes stamp-in {
            0% { transform: scale(1.4) rotate(-8deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        .fade-up {
            animation: fade-up 0.5s ease-out both;
        }
        .fade-up-d1 { animation-delay: 0.1s; }
        .fade-up-d2 { animation-delay: 0.2s; }
        @keyframes fade-up {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen bg-zinc-100 font-sans antialiased dark:bg-zinc-900">

    <div class="mx-auto w-full max-w-[780px] px-4 py-4 sm:py-6">

        {{-- Toolbar --}}
        <div class="no-print mb-5 flex items-center justify-center">
            <div class="flex gap-2">
                <button aria-label="Share certificate" onclick="if (navigator.share) { navigator.share({ title: 'Membership Certificate — Scouts South Africa', url: window.location.href }).catch(() => {}) } else { navigator.clipboard.writeText(window.location.href).then(() => { const el = this; el.querySelector('span').textContent = 'Link Copied!'; setTimeout(() => el.querySelector('span').textContent = 'Share', 2000) }) }"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-medium text-zinc-600 shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-50 hover:text-zinc-900 active:scale-95 dark:bg-zinc-800 dark:text-zinc-300 dark:ring-zinc-700 dark:hover:bg-zinc-700 dark:hover:text-white">
                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.935-2.186 2.25 2.25 0 0 0-3.935 2.186Z" /></svg>
                    <span>Share</span>
                </button>
                <button aria-label="Print certificate or save as PDF" onclick="window.print()"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-medium text-zinc-600 shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-50 hover:text-zinc-900 active:scale-95 dark:bg-zinc-800 dark:text-zinc-300 dark:ring-zinc-700 dark:hover:bg-zinc-700 dark:hover:text-white">
                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
                    Print / PDF
                </button>


                {{-- Theme toggle --}}
                <div class="flex items-center rounded-lg bg-white shadow-sm ring-1 ring-zinc-200 dark:bg-zinc-800 dark:ring-zinc-700" id="theme-toggle">
                    {{-- Light --}}
                    <button onclick="setTheme('light')" title="Light mode"
                        class="theme-btn inline-flex items-center rounded-l-lg px-2 py-1.5 text-zinc-400 transition hover:text-zinc-900 dark:hover:text-white" data-theme="light">
                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                    </button>
                    {{-- System --}}
                    <button onclick="setTheme('system')" title="System preference"
                        class="theme-btn inline-flex items-center border-x border-zinc-200 px-2 py-1.5 text-zinc-400 transition hover:text-zinc-900 dark:border-zinc-700 dark:hover:text-white" data-theme="system">
                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z" /></svg>
                    </button>
                    {{-- Dark --}}
                    <button onclick="setTheme('dark')" title="Dark mode"
                        class="theme-btn inline-flex items-center rounded-r-lg px-2 py-1.5 text-zinc-400 transition hover:text-zinc-900 dark:hover:text-white" data-theme="dark">
                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Certificate Card --}}
        <div class="certificate-outer overflow-hidden rounded-2xl bg-white shadow-xl shadow-zinc-300/40 ring-1 ring-zinc-200/80 dark:bg-zinc-800 dark:shadow-black/30 dark:ring-zinc-700">

            {{-- Top accent bar --}}
            <div class="h-1.5 bg-gradient-to-r from-[#622599] via-[#7B4DB8] to-[#622599]"></div>

            {{-- Header --}}
            <div class="print-header relative overflow-hidden bg-[#622599] px-8 pb-6 pt-6 text-center sm:px-12">
                {{-- Decorative fleur-de-lis pattern (subtle) --}}
                <div class="pointer-events-none absolute inset-0 opacity-[0.035]" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22%3E%3Cpath d=%22M20 5l3 8h-6l3-8zm0 30l-3-8h6l-3 8zm-15-15l8 3v-6l-8 3zm30 0l-8-3v6l8-3z%22 fill=%22white%22/%3E%3C/svg%3E'); background-size: 40px 40px;"></div>
                {{-- Gradient overlay --}}
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/10"></div>

                <div class="relative">
                    {{-- Logo --}}
                    <div class="print-header-logo mx-auto mb-3 flex size-14 items-center justify-center rounded-full bg-white/15 ring-2 ring-white/25">
                        <img src="{{ asset('images/logo.png') }}" alt="Scouts South Africa" class="size-8 object-contain drop-shadow-sm">
                    </div>

                    <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-purple-200/80">Scouts South Africa</p>
                    <h1 class="mt-1.5 text-xl font-bold tracking-tight text-white sm:text-2xl">Membership Certificate</h1>
                    <div class="header-divider mx-auto mt-3 flex w-32 items-center gap-2">
                        <div class="h-px flex-1 bg-white/20"></div>
                        <svg class="size-3 text-purple-300/60" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <div class="h-px flex-1 bg-white/20"></div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="print-body px-8 py-8 sm:px-12 sm:py-10">

                {{-- Member identity card --}}
                <div class="fade-up flex items-start gap-5">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt=""
                            class="size-20 shrink-0 rounded-xl object-cover shadow-md ring-2 ring-white sm:size-[100px] dark:ring-zinc-700">
                    @endif
                    <div class="min-w-0 pt-1">
                        @if (in_array('name', $visibleFields))
                            <h2 class="text-xl font-bold tracking-tight text-zinc-900 sm:text-2xl dark:text-zinc-100">{{ $user->name }}</h2>
                        @endif
                        @if (in_array('ssa_id', $visibleFields))
                            <div class="mt-2 inline-flex items-center gap-1.5 rounded-md bg-[#622599]/8 px-2.5 py-1 text-xs font-bold tracking-wide text-[#622599] dark:bg-[#622599]/20 dark:text-purple-300">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" /></svg>
                                {{ $user->ssaId }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Details grid --}}
                @if (array_intersect(['email', 'phone', 'age', 'date_invested'], $visibleFields))
                    <div class="fade-up fade-up-d1 mt-8 rounded-xl border border-zinc-100 bg-zinc-50/60 px-5 py-5 dark:border-zinc-700 dark:bg-zinc-900/50">
                        <h3 class="mb-4 text-[11px] font-bold uppercase tracking-[0.12em] text-zinc-400 dark:text-zinc-500">Member Details</h3>
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @if (in_array('email', $visibleFields) && $user->username)
                                <div class="flex items-start gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-100 dark:bg-zinc-800 dark:text-zinc-500 dark:ring-zinc-700">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <dt class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Email</dt>
                                        <dd class="mt-0.5 truncate text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $user->username }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if (in_array('phone', $visibleFields) && $user->cellNr)
                                <div class="flex items-start gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-100 dark:bg-zinc-800 dark:text-zinc-500 dark:ring-zinc-700">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <dt class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Phone</dt>
                                        <dd class="mt-0.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $user->cellNr }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if (in_array('age', $visibleFields) && $user->dob)
                                <div class="flex items-start gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-100 dark:bg-zinc-800 dark:text-zinc-500 dark:ring-zinc-700">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <dt class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Age</dt>
                                        <dd class="mt-0.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $user->dob->age }} years</dd>
                                    </div>
                                </div>
                            @endif
                            @if (in_array('date_invested', $visibleFields) && $user->dateInvested)
                                <div class="flex items-start gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-100 dark:bg-zinc-800 dark:text-zinc-500 dark:ring-zinc-700">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <dt class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Date Invested</dt>
                                        <dd class="mt-0.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $user->dateInvested->format('d F Y') }}</dd>
                                    </div>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

                {{-- Active Roles --}}
                @if (in_array('roles', $visibleFields) && $activeRoles->isNotEmpty())
                    <div class="fade-up fade-up-d2 mt-8">
                        <h3 class="mb-3 text-[11px] font-bold uppercase tracking-[0.12em] text-zinc-400 dark:text-zinc-500">Active Roles</h3>
                        <div class="space-y-2">
                            @foreach ($activeRoles as $attachment)
                                <div class="flex items-center gap-3 rounded-xl border border-zinc-100 bg-white px-4 py-3 shadow-sm dark:border-zinc-700 dark:bg-zinc-900/50">
                                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-[#622599]/8 dark:bg-[#622599]/20">
                                        <svg class="size-4 text-[#622599] dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $attachment->role?->name ?? 'Unknown Role' }}</p>
                                        @php
                                            $scope = collect([
                                                $attachment->group?->name,
                                                $attachment->district?->name,
                                                $attachment->region?->name,
                                            ])->filter()->implode(' — ');
                                        @endphp
                                        @if ($scope)
                                            <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $scope }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Status Stamp --}}
                <div class="print-stamp-wrap mt-10 flex justify-center">
                    <div class="stamp relative inline-flex flex-col items-center">
                        @if ($isActiveMember)
                            {{-- Verified --}}
                            <div class="print-stamp flex size-40 items-center justify-center rounded-full border-[3px] border-dashed border-green-500/60 sm:size-44 dark:border-green-400/40">
                                <div class="print-stamp-inner flex size-[136px] flex-col items-center justify-center rounded-full border-[2.5px] border-green-600 sm:size-[152px] dark:border-green-500">
                                    <svg class="size-7 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                    </svg>
                                    <span class="mt-1 text-xs font-extrabold uppercase tracking-[0.15em] text-green-700 dark:text-green-400">Verified</span>
                                    <span class="text-xs font-extrabold uppercase tracking-[0.15em] text-green-700 dark:text-green-400">Member</span>
                                    <div class="mx-auto mt-1.5 h-px w-12 bg-green-300/60 dark:bg-green-500/40"></div>
                                    <span class="mt-1.5 text-[10px] font-bold tabular-nums text-green-600/80 dark:text-green-400/80">{{ now()->format('d M Y') }}</span>
                                </div>
                            </div>
                        @else
                            {{-- Inactive --}}
                            <div class="print-stamp flex size-40 items-center justify-center rounded-full border-[3px] border-dashed border-red-500/60 sm:size-44 dark:border-red-400/40">
                                <div class="print-stamp-inner flex size-[136px] flex-col items-center justify-center rounded-full border-[2.5px] border-red-600 sm:size-[152px] dark:border-red-500">
                                    <svg class="size-7 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span class="mt-1 text-xs font-extrabold uppercase tracking-[0.15em] text-red-700 dark:text-red-400">Inactive</span>
                                    <span class="text-xs font-extrabold uppercase tracking-[0.15em] text-red-700 dark:text-red-400">Member</span>
                                    <div class="mx-auto mt-1.5 h-px w-12 bg-red-300/60 dark:bg-red-500/40"></div>
                                    <span class="mt-1.5 text-[10px] font-bold tabular-nums text-red-600/80 dark:text-red-400/80">{{ now()->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="print-footer border-t border-zinc-100 bg-zinc-50/70 px-8 py-5 sm:px-12 dark:border-zinc-700 dark:bg-zinc-900/50">
                <div class="flex flex-col items-center gap-4 text-center">
                    {{-- QR Code --}}
                    <div class="flex flex-col items-center gap-1">
                        <div class="print-qr size-16 rounded-lg bg-white p-1 shadow-sm ring-1 ring-zinc-100 dark:ring-zinc-700">
                            <img src="{{ $qrCode }}" alt="QR code to verify this certificate" class="size-full">
                        </div>
                        <p class="text-[9px] font-medium text-zinc-400 dark:text-zinc-500">Scan to verify</p>
                    </div>
                    @if ($isActiveMember)
                        <p class="max-w-md text-[11px] leading-relaxed text-zinc-400 dark:text-zinc-500">
                            This certificate confirms active membership with Scouts South Africa as of {{ now()->format('d F Y') }}.
                            It is not a nomination, letter of endorsement, or letter of introduction.
                        </p>
                    @else
                        <p class="max-w-md text-[11px] leading-relaxed text-red-400 dark:text-red-500">
                            This member is no longer active with Scouts South Africa as of {{ now()->format('d F Y') }}.
                            This certificate is no longer valid.
                        </p>
                    @endif
                    <div class="flex flex-wrap items-center justify-center gap-x-3 gap-y-1 text-[10px] text-zinc-300 dark:text-zinc-600">
                        <span class="font-mono tracking-tight">{{ $certificate->uuid }}</span>
                    </div>
                </div>
            </div>

            {{-- Bottom accent bar --}}
            <div class="h-1 bg-gradient-to-r from-[#622599] via-[#7B4DB8] to-[#622599]"></div>
        </div>

        {{-- Attribution --}}
        <div class="no-print mt-5 flex items-center justify-center gap-3 text-[11px] text-zinc-400 dark:text-zinc-500">
            <img src="{{ asset('images/logo.png') }}" alt="Scouts South Africa" class="size-5 object-contain">
            <span>Scouts South Africa &middot; Verified by <a href="{{ route('home') }}" class="font-medium text-zinc-500 underline decoration-zinc-300 underline-offset-2 transition hover:text-zinc-700 dark:text-zinc-400 dark:decoration-zinc-600 dark:hover:text-zinc-200">Ssalute</a></span>
            <img src="{{ asset('icons/favicon-196.png') }}" alt="Ssalute" class="size-5 rounded object-contain">
        </div>
    </div>

<script>
    function setTheme(theme) {
        localStorage.setItem('cert-theme', theme);
        if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        updateToggle(theme);
    }
    function updateToggle(theme) {
        document.querySelectorAll('.theme-btn').forEach(btn => {
            const active = btn.dataset.theme === theme;
            btn.classList.toggle('text-zinc-900', active && !document.documentElement.classList.contains('dark'));
            btn.classList.toggle('dark:text-white', active);
            btn.classList.toggle('text-zinc-400', !active);
        });
    }
    updateToggle(localStorage.getItem('cert-theme') || 'system');
</script>
</body>
</html>
