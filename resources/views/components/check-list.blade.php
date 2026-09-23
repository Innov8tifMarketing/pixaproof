{{--
Check List Component

Bulleted list with a solid check icon per item.

Usage:
<x-check-list :items="['First point', 'Second point']" />
<x-check-list :items="$bullets" compact />

Props:
- items: list<string>
- compact: tighter spacing for mobile accordions (default: false)
--}}

@props([
    'items' => [],
    'compact' => false,
])

<ul {{ $attributes->merge(['class' => ($compact ? 'space-y-2' : 'space-y-3').' text-neutral-700']) }}>
    @foreach ($items as $item)
        <li class="flex items-start {{ $compact ? 'gap-2' : 'gap-3' }}">
            <x-heroicon-s-check class="text-primary-600 mt-0.5 h-5 w-5 shrink-0" />
            {{ $item }}
        </li>
    @endforeach
</ul>
