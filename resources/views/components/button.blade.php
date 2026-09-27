{{--
Button Component (Enterprise Design System)

Usage:
<x-button href="/contact">Request Demo</x-button>
<x-button href="/docs" variant="secondary">Learn More</x-button>
<x-button type="submit" variant="primary">Submit</x-button>
<x-button href="/docs" variant="ghost">Read Docs</x-button>
<x-button href="/contact" size="lg" icon>Request Demo</x-button>

Variants:
- primary: Amber fill, white text (CTA - default)
- secondary: Sky blue border, sky text
- ghost: Text only with hover underline
- outline: Neutral border, slate text

Sizes:
- sm: Smaller padding
- md: Default
- lg: Larger padding

Icons:
- icon: Adds arrow icon (default true for primary)
--}}

@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'type' => 'button',
])

@php
    // Default icon behavior: primary has icon by default
    $showIcon = $icon ?? ($variant === 'primary');

    $baseClasses = 'inline-flex items-center justify-center font-medium rounded transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2';

    $variantClasses = match ($variant) {
        'secondary' => 'border border-primary-600 text-primary-700 hover:bg-primary-50',
        'ghost' => 'text-primary-600 hover:text-primary-700 hover:underline',
        'outline' => 'border border-neutral-300 text-neutral-700 hover:bg-neutral-50',
        default => 'bg-accent-500 text-white hover:bg-accent-600 shadow-sm',
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-4 py-2 text-sm gap-1.5',
        'lg' => 'px-8 py-4 text-lg gap-3',
        default => 'px-6 py-3 text-base gap-2',
    };

    $iconSize = match ($size) {
        'sm' => 'h-3.5 w-3.5',
        'lg' => 'h-5 w-5',
        default => 'h-4 w-4',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses} {$sizeClasses}"]) }}>
        {{ $slot }}
        @if ($showIcon)
            <svg class="{{ $iconSize }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses} {$sizeClasses}"]) }}>
        {{ $slot }}
        @if ($showIcon)
            <svg class="{{ $iconSize }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        @endif
    </button>
@endif
