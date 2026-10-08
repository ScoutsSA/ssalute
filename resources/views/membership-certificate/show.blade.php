<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $issuedOn = now();
        $metaTitle = $user->name . ', Membership Certificate';
        $metaDescription = $isActiveMember
            ? $user->name . ' is a verified active member of SCOUTS South Africa. View this certificate to confirm membership status.'
            : $user->name . ' is no longer an active member of SCOUTS South Africa. This certificate is not valid.';
        $metaUrl = route('membership-certificate.show', $certificate->uuid);
        $metaImage = $photoUrl ?: asset('images/brand/ssa-logo-white-on-purple.png');
    @endphp

    <title>{{ $metaTitle }}, SCOUTS South Africa</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:site_name" content="SCOUTS South Africa, Ssalute">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $photoUrl ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    @vite(['resources/css/app.css'])
    <script>
        {{-- The ground and toolbar follow the OS theme. The certificate sheet itself is a document and is always white. --}}
        (function () {
            const media = window.matchMedia('(prefers-color-scheme: dark)');
            const apply = () => document.documentElement.classList.toggle('dark', media.matches);
            apply();
            media.addEventListener('change', apply);
        })();
    </script>
    <style>
        .certificate {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            color: #1E1E1E;
            font-size: 14px;
            line-height: 1.5;
        }
        .certificate h1,
        .certificate h2,
        .certificate h3 {
            font-weight: 700;
        }
        .certificate .logo {
            width: 11rem;
        }
        .fade-up {
            animation: fade-up 0.5s ease-out both;
        }
        .fade-up-d1 { animation-delay: 0.1s; }
        .fade-up-d2 { animation-delay: 0.2s; }
        @keyframes fade-up {
            0% { opacity: 0; transform: translateY(8px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @media (prefers-reduced-motion: reduce) {
            .fade-up { animation: none; }
        }
        @page {
            size: A4 portrait;
            margin: 0;
        }
        @media print {
            html, body {
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
                color-scheme: light !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            .fade-up { animation: none !important; }
            .page-ground { padding: 0 !important; max-width: none !important; }
            .certificate {
                width: 210mm;
                min-height: 297mm;
                margin: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: 0 !important;
                font-size: 10.5pt;
            }
            .certificate .band { padding: 12mm 16mm 10mm !important; }
            .certificate .logo { width: 64mm !important; }
            .certificate .identification { padding-left: 16mm !important; padding-right: 16mm !important; }
            .certificate .body { padding: 10mm 16mm !important; }
            .certificate .foot { padding: 6mm 16mm 4mm !important; }
            .certificate .rope { padding: 0 10mm 6mm !important; }
            .certificate .status, .certificate .role, .certificate .details { break-inside: avoid; }
        }
    </style>
</head>
<body class="min-h-screen bg-zinc-100 font-sans antialiased dark:bg-zinc-900">

    <div class="page-ground mx-auto w-full max-w-[800px] px-4 py-4 sm:py-6">

        {{-- Toolbar --}}
        <div class="no-print mb-5 flex items-center justify-center gap-2">
            <button type="button" aria-label="Share certificate" onclick="if (navigator.share) { navigator.share({ title: 'Membership Certificate, SCOUTS South Africa', url: window.location.href }).catch(() => {}) } else { navigator.clipboard.writeText(window.location.href).then(() => { const el = this; el.querySelector('span').textContent = 'Link copied'; setTimeout(() => el.querySelector('span').textContent = 'Share', 2000) }) }"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-medium text-zinc-600 shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-50 hover:text-zinc-900 active:scale-95 dark:bg-zinc-800 dark:text-zinc-300 dark:ring-zinc-700 dark:hover:bg-zinc-700 dark:hover:text-white">
                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.935-2.186 2.25 2.25 0 0 0-3.935 2.186Z" /></svg>
                <span>Share</span>
            </button>
            <button type="button" aria-label="Print certificate or save as PDF" onclick="window.print()"
                class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-medium text-zinc-600 shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-50 hover:text-zinc-900 active:scale-95 dark:bg-zinc-800 dark:text-zinc-300 dark:ring-zinc-700 dark:hover:bg-zinc-700 dark:hover:text-white">
                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
                Print / PDF
            </button>
        </div>

        {{-- The certificate sheet: SSA corporate CI, always white --}}
        <article class="certificate flex flex-col overflow-hidden rounded-lg bg-white shadow-xl shadow-zinc-300/40 ring-1 ring-zinc-200/80 dark:shadow-black/30 dark:ring-zinc-700">

            {{-- Purple band: logo left, title right --}}
            <div class="band flex flex-wrap items-center justify-between gap-x-8 gap-y-4 bg-[#622599] px-6 py-6 text-white sm:px-10 sm:py-8">
                <x-ssa.logo variant="on-purple" class="logo shrink-0" />
                <div class="min-w-0 text-left sm:text-right">
                    <h1 class="text-xl leading-tight sm:text-2xl">Membership Certificate</h1>
                    <p class="mt-1 text-xs text-white/80">Issued {{ $issuedOn->format('d F Y') }}</p>
                </div>
            </div>

            {{-- Identification bar, mirroring the National letterhead --}}
            <div class="identification bg-[#F3EEFA] px-6 py-2 text-[11px] font-bold uppercase tracking-[0.12em] text-[#622599] sm:px-10">
                <x-ssa.membership-line />
            </div>

            {{-- Body --}}
            <div class="body flex-1 px-6 py-8 sm:px-10 sm:py-10">

                {{-- Member identity --}}
                <div class="fade-up flex items-start gap-5">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt=""
                            class="size-20 shrink-0 rounded-md object-cover ring-1 ring-zinc-200 sm:size-24">
                    @endif
                    <div class="min-w-0 pt-0.5">
                        <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-zinc-500">This certifies that</p>
                        @if (in_array('name', $visibleFields))
                            <h2 class="mt-1 text-xl leading-tight sm:text-2xl">{{ $user->name }}</h2>
                        @endif
                        @if (in_array('ssa_id', $visibleFields))
                            <p class="mt-2 inline-block rounded bg-[#F3EEFA] px-2.5 py-1 text-xs font-bold tracking-wide text-[#622599]">
                                {{ $user->ssaId }}
                            </p>
                        @endif
                        <p class="mt-3 max-w-md text-sm text-zinc-700">
                            @if ($isActiveMember)
                                is a registered and active member of SCOUTS South Africa.
                            @else
                                was a registered member of SCOUTS South Africa and is no longer active.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Details --}}
                @if (array_intersect(['email', 'phone', 'age', 'date_invested'], $visibleFields))
                    <div class="details fade-up fade-up-d1 mt-8 border-t border-zinc-200 pt-6">
                        <h3 class="mb-3 text-[11px] uppercase tracking-[0.12em] text-zinc-500">Member details</h3>
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-3 sm:grid-cols-2">
                            @if (in_array('email', $visibleFields) && $user->username)
                                <div class="min-w-0">
                                    <dt class="text-[11px] uppercase tracking-wider text-zinc-500">Email</dt>
                                    <dd class="truncate text-sm font-bold">{{ $user->username }}</dd>
                                </div>
                            @endif
                            @if (in_array('phone', $visibleFields) && $user->cellNr)
                                <div class="min-w-0">
                                    <dt class="text-[11px] uppercase tracking-wider text-zinc-500">Phone</dt>
                                    <dd class="text-sm font-bold">{{ $user->cellNr }}</dd>
                                </div>
                            @endif
                            @if (in_array('age', $visibleFields) && $user->dob)
                                <div class="min-w-0">
                                    <dt class="text-[11px] uppercase tracking-wider text-zinc-500">Age</dt>
                                    <dd class="text-sm font-bold">{{ $user->dob->age }} years</dd>
                                </div>
                            @endif
                            @if (in_array('date_invested', $visibleFields) && $user->dateInvested)
                                <div class="min-w-0">
                                    <dt class="text-[11px] uppercase tracking-wider text-zinc-500">Date invested</dt>
                                    <dd class="text-sm font-bold">{{ $user->dateInvested->format('d F Y') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

                {{-- Active roles --}}
                @if (in_array('roles', $visibleFields) && $activeRoles->isNotEmpty())
                    <div class="fade-up fade-up-d2 mt-8 border-t border-zinc-200 pt-6">
                        <h3 class="mb-3 text-[11px] uppercase tracking-[0.12em] text-zinc-500">Active roles</h3>
                        <ul class="divide-y divide-zinc-100">
                            @foreach ($activeRoles as $attachment)
                                @php
                                    $scope = collect([
                                        $attachment->group?->name,
                                        $attachment->district?->name,
                                        $attachment->region?->name,
                                    ])->filter()->implode(' · ');
                                @endphp
                                <li class="role flex items-start gap-3 py-2.5">
                                    <span class="mt-1.5 size-2 shrink-0 rounded-full bg-[#622599]" aria-hidden="true"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold">{{ $attachment->role?->name ?? 'Unknown role' }}</p>
                                        @if ($scope)
                                            <p class="text-xs text-zinc-600">{{ $scope }}</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Status --}}
                <div class="status mt-10">
                    @if ($isActiveMember)
                        <div class="flex items-start gap-4 rounded-md bg-[#622599] px-5 py-4 text-white">
                            <svg class="mt-0.5 size-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                            <div>
                                <p class="text-base font-bold">Verified member</p>
                                <p class="mt-0.5 text-sm text-white/85">Active membership of SCOUTS South Africa confirmed as at {{ $issuedOn->format('d F Y') }}.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-4 rounded-md border-2 border-zinc-400 bg-zinc-200 px-5 py-4 text-zinc-900">
                            <svg class="mt-0.5 size-6 shrink-0 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                            <div>
                                <p class="text-base font-bold">No longer an active member</p>
                                <p class="mt-0.5 text-sm text-zinc-700">This certificate is not valid as at {{ $issuedOn->format('d F Y') }}. The named person holds no active role in SCOUTS South Africa.</p>
                            </div>
                        </div>
                    @endif
                    <p class="mt-4 text-xs leading-relaxed text-zinc-600">
                        This certificate confirms membership only. It is not a nomination, a letter of endorsement or a letter of introduction. Membership status is live: scan the code or open the link below to see the current position.
                    </p>
                </div>
            </div>

            {{-- Footer: contact block, verification, reference --}}
            <div class="foot border-t border-zinc-200 px-6 py-5 sm:px-10">
                <div class="flex flex-wrap items-end justify-between gap-x-8 gap-y-4">
                    <div class="text-xs leading-relaxed text-zinc-700">
                        <p class="font-bold text-[#1E1E1E]">SCOUTS South Africa, National Office</p>
                        <p>info@scouts.org.za</p>
                        <p>www.scouts.org.za</p>
                        <p class="mt-2 font-mono text-[10px] tracking-tight text-zinc-500">Certificate {{ $certificate->uuid }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right text-[10px] leading-snug text-zinc-500">
                            <p class="font-bold text-zinc-700">Scan to verify</p>
                            <p>Live status on ssalute</p>
                        </div>
                        <div class="size-16 shrink-0 rounded bg-white p-0.5 ring-1 ring-zinc-200">
                            <img src="{{ $qrCode }}" alt="QR code to verify this certificate" class="size-full">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rope with "be prepared": corporate CI, mirrors the National letterhead footer --}}
            <div class="rope px-4 pb-4 pt-1 sm:px-6">
                <img src="{{ asset('images/brand/ssa-rope-flag-be-prepared.svg') }}" alt="" draggable="false" class="block h-auto w-full select-none">
            </div>
        </article>

        {{-- Attribution: the product, credited off print --}}
        <div class="no-print mt-5 flex items-center justify-center gap-2 text-[11px] text-zinc-500 dark:text-zinc-400">
            <img src="{{ asset('images/logo.png') }}" alt="" class="size-5 object-contain">
            <span>Issued by <a href="{{ route('home') }}" class="font-medium text-zinc-600 underline decoration-zinc-300 underline-offset-2 transition hover:text-zinc-900 dark:text-zinc-300 dark:decoration-zinc-600 dark:hover:text-white">Ssalute</a>, the SCOUTS South Africa member system</span>
        </div>
    </div>
</body>
</html>
