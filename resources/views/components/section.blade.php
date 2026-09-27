{{--
Section Component (Homepage Shell)

Reveal-on-scroll section with the standard centered header. The header is only
rendered when at least one of eyebrow / title / description is given. Children
can read the parent Alpine `visible` state (the stats strip uses it for counters).

Usage:
<x-section id="faq" eyebrow="FAQ" title="Frequently Asked Questions" width="max-w-3xl">
    ...
</x-section>

<x-section class="bg-neutral-50" width="max-w-6xl" headerSpacing="mb-16">
    <x-slot:background>
        <div class="absolute inset-0 ..."></div>
    </x-slot:background>
    ...
</x-section>

Props:
- id: anchor id (optional)
- eyebrow / title / description: header copy (all optional)
- width: container max width (default: max-w-7xl)
- descriptionWidth: header paragraph max width (default: max-w-3xl)
- headerSpacing: margin below the header (default: mb-12)
- padding: vertical section padding (default: py-20 lg:py-28)
- intersect: x-intersect.once expression (default: visible = true)

Slots:
- background: decorative layers rendered before the reveal container
--}}

@props([
    'id' => null,
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'width' => 'max-w-7xl',
    'descriptionWidth' => 'max-w-3xl',
    'headerSpacing' => 'mb-12',
    'padding' => 'py-20 lg:py-28',
    'intersect' => 'visible = true',
])

@php
    $hasHeader = filled($eyebrow) || filled($title) || filled($description);
@endphp

<section
    @if ($id) id="{{ $id }}" @endif
    {{ $attributes->merge(['class' => $padding]) }}
    x-data="{ visible: false }"
    x-intersect.once="{{ $intersect }}"
>
    @isset($background)
        {{ $background }}
    @endisset

    <div
        class="relative mx-auto {{ $width }} px-4 transition-all duration-700 ease-out"
        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
    >
        @if ($hasHeader)
            <div class="{{ $headerSpacing }} text-center">
                @if (filled($eyebrow))
                    <p class="text-primary-600 font-heading mb-4 text-sm font-semibold tracking-wider uppercase">
                        {{ $eyebrow }}
                    </p>
                @endif
                @if (filled($title))
                    <h2 class="font-heading mb-6 text-3xl font-bold text-neutral-900 md:text-4xl">{{ $title }}</h2>
                @endif
                @if (filled($description))
                    <p class="mx-auto {{ $descriptionWidth }} text-lg text-neutral-600">{{ $description }}</p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</section>
