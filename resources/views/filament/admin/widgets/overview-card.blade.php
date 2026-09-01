@php
    $accent = fn (string $color): string => match ($color) {
        'success' => 'text-success-600 dark:text-success-400',
        'danger' => 'text-danger-600 dark:text-danger-400',
        'warning' => 'text-warning-600 dark:text-warning-400',
        'gray' => 'text-gray-400 dark:text-gray-500',
        default => 'text-primary-600 dark:text-primary-400',
    };
    $tileGrid = match ($tileColumns ?? 4) {
        2 => 'sm:grid-cols-2',
        3 => 'sm:grid-cols-2 lg:grid-cols-3',
        default => 'sm:grid-cols-2 lg:grid-cols-4',
    };
@endphp

<x-filament-widgets::widget>
<div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    {{-- Header --}}
    <div class="flex items-center gap-4 border-b border-gray-100 bg-linear-to-r from-primary-500/10 to-transparent px-6 py-5 dark:border-white/10">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-500/15 text-primary-600 dark:text-primary-400">
            @svg($icon, 'h-6 w-6')
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-950 dark:text-white">{{ $heading }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subheading }}</p>
        </div>
    </div>

    {{-- Stat tiles --}}
    <div class="grid grid-cols-1 gap-px bg-gray-100 dark:bg-white/10 {{ $tileGrid }}">
        @foreach ($stats as $stat)
            @php($color = $stat['color'] ?? 'primary')
            @php($url = $stat['url'] ?? null)
            <{{ $url ? 'a' : 'div' }} @if ($url) href="{{ $url }}" @endif class="group block bg-white px-6 py-5 dark:bg-gray-900 {{ $url ? 'transition hover:bg-gray-50 dark:hover:bg-white/5' : '' }}">
                <div class="flex items-center gap-2 {{ $accent($color) }}">
                    @svg($stat['icon'], 'h-4 w-4 shrink-0')
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                    @if ($url)
                        @svg('heroicon-m-arrow-right', 'ml-auto h-4 w-4 shrink-0 text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-gray-500 dark:text-gray-600 dark:group-hover:text-gray-300')
                    @endif
                </div>
                <p class="mt-3 text-xl font-bold {{ in_array($color, ['success', 'danger', 'warning'], true) ? $accent($color) : 'text-gray-950 dark:text-white' }}">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ $stat['description'] ?? '' }}</p>
            </{{ $url ? 'a' : 'div' }}>
        @endforeach
    </div>
</div>
</x-filament-widgets::widget>
