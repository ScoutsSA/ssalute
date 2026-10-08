@props([
    'variant' => 'on-purple',
])

@php
    $file = match ($variant) {
        'on-white' => 'ssa-logo-purple-on-white',
        default => 'ssa-logo-white-on-purple',
    };
@endphp

{{--
    The SCOUTS South Africa logo, placed as supplied by the National Office.
    Never inline, recolour, filter, crop or redraw it. Keep it at or above
    roughly 120px wide so "South Africa" stays legible (brand manual 2.2).
--}}
<img
    src="{{ asset("images/brand/{$file}.svg") }}"
    alt="SCOUTS South Africa"
    draggable="false"
    {{ $attributes->class(['block h-auto min-w-[120px] select-none']) }}
/>
