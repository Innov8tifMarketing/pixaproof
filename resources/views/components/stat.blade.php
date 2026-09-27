{{--
Stat Component (Statistics Strip)

Large animated figure with a label. Must be placed inside an element that owns
an Alpine `visible` boolean (e.g. <x-section>); the counter starts when it flips.

Usage:
<x-stat value="10" suffix="M+" label="Verifications Processed" />
<x-stat text="<500ms" label="Verification Speed" />

Props:
- label: caption under the figure
- value: integer animated via Motion.animateCounter
- suffix: appended after the animated value (default: '')
- text: static string shown instead of a counter
--}}

@props([
    'label',
    'value' => null,
    'suffix' => '',
    'text' => null,
])

<div {{ $attributes }}>
    <div
        class="font-heading mb-2 text-4xl font-bold text-white md:text-5xl"
        x-show="visible"
        x-transition
        @if ($text !== null)
            x-text="visible ? {{ Js::from($text) }} : '0'"
        @else
            x-init="$watch('visible', v => { if (v) Motion.animateCounter($el, {{ Js::from((int) $value) }}, {{ Js::from($suffix) }}) })"
        @endif
    >
        0
    </div>
    <div class="text-primary-100 font-heading text-sm tracking-wider uppercase">{{ $label }}</div>
</div>
