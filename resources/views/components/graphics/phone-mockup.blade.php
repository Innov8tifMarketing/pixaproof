{{--
Phone Mockup Component
Lightweight CSS-only phone frame with customizable screen content.
No external dependencies — uses Tailwind classes for the bezel, notch, and buttons.

Usage:
<x-graphics.phone-mockup image="images/example.webp" imageAlt="Example" />
<x-graphics.phone-mockup variant="success" size="lg" />
<x-graphics.phone-mockup size="lg" image="images/bg.webp">
    <div>Custom overlay content</div>
</x-graphics.phone-mockup>

Props:
- variant: 'default' | 'success' | 'error' | 'scanning'
- size: 'sm' | 'md' | 'lg' (default: 'md')
- image: optional background image path
- imageAlt: alt text for image
- overlay: 'dark' | 'light' | null
--}}

@props([
    'variant' => 'default',
    'size' => 'md',
    'image' => null,
    'imageAlt' => '',
    'overlay' => null,
])

@php
    $sizes = [
        'sm' => 'w-32',
        'md' => 'w-40',
        'lg' => 'w-52',
        'xl' => 'w-64',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => $sizeClass]) }}>
    {{-- Phone bezel --}}
    <div class="relative overflow-hidden rounded-[2rem] border-[3px] border-neutral-800 bg-neutral-900 p-1.5 shadow-xl">
        {{-- Side buttons (volume + power) --}}
        <div class="absolute -left-[4px] top-[4.5rem] h-6 w-[3px] rounded-l bg-neutral-700"></div>
        <div class="absolute -left-[4px] top-[6.5rem] h-10 w-[3px] rounded-l bg-neutral-700"></div>
        <div class="absolute -left-[4px] top-[8.5rem] h-10 w-[3px] rounded-l bg-neutral-700"></div>
        <div class="absolute -right-[4px] top-[6rem] h-12 w-[3px] rounded-r bg-neutral-700"></div>

        {{-- Screen --}}
        <div class="relative aspect-[9/19.5] overflow-hidden rounded-[1.5rem] bg-neutral-950">
            {{-- Screen content --}}
            @if ($slot->isEmpty())
                <div class="relative h-full w-full">
                    {{-- Background image --}}
                    @if ($image)
                        <img
                            src="{{ asset($image) }}"
                            alt="{{ $imageAlt }}"
                            class="absolute inset-0 h-full w-full object-cover"
                        >
                        @if ($overlay === 'dark')
                            <div class="absolute inset-0 bg-black/40"></div>
                        @elseif ($overlay === 'light')
                            <div class="absolute inset-0 bg-white/30"></div>
                        @endif
                    @endif

                    {{-- Variant overlays --}}
                    @if ($variant === 'scanning')
                        <div
                            class=" rounded-[1.5rem] absolute inset-0 flex flex-col items-center justify-center {{ $image ? 'bg-neutral-900/70 backdrop-blur-sm' : '' }} p-4"
                        >
                            <div class="relative mb-3 h-10 w-10 rounded-full border-2 border-primary-500">
                                <div
                                    class="absolute inset-0 animate-ping rounded-full border-2 border-primary-500 opacity-20"
                                ></div>
                                <div class="flex h-full items-center justify-center">
                                    <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-[0.6rem] font-medium text-white">Scanning</p>
                            <p class="mt-0.5 text-[0.5rem] text-neutral-400">Hold steady...</p>
                        </div>
                    @elseif ($variant === 'success')
                        <div
                            class="absolute inset-0 rounded-[1.5rem] flex flex-col items-center justify-center {{ $image ? 'bg-neutral-900/70 backdrop-blur-sm' : '' }} p-4"
                        >
                            <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-full bg-green-500/20">
                                <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <p class="text-[0.6rem] font-medium text-white">Verified</p>
                            <p class="mt-0.5 text-[0.5rem] text-green-400">Authenticity confirmed</p>
                        </div>
                    @elseif ($variant === 'error')
                        <div
                            class="absolute inset-0 rounded-[1.5rem] flex flex-col items-center justify-center {{ $image ? 'bg-neutral-900/70 backdrop-blur-sm' : '' }} p-4"
                        >
                            <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-full bg-red-500/20">
                                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <p class="text-[0.6rem] font-medium text-white">Blocked</p>
                            <p class="mt-0.5 text-[0.5rem] text-red-400">Gallery upload detected</p>
                        </div>
                    @else
                        @if ($image)
                            {{-- Image-only: no extra overlay --}}
                        @else
                            {{-- Default: Camera viewfinder UI --}}
                            <div class="flex h-full w-full flex-col bg-neutral-950">
                                <div
                                    class="flex items-center justify-between px-3 pt-5 pb-1 text-[0.45rem] text-neutral-400"
                                >
                                    <span>9:41</span>
                                    <div class="flex items-center gap-0.5">
                                        <svg class="h-2 w-2" fill="currentColor" viewBox="0 0 24 24"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" /></svg>
                                        <svg class="h-2 w-2" fill="currentColor" viewBox="0 0 24 24"><path d="M15.67 4H14V2h-4v2H8.33C7.6 4 7 4.6 7 5.33v15.33C7 21.4 7.6 22 8.33 22h7.33c.74 0 1.34-.6 1.34-1.33V5.33C17 4.6 16.4 4 15.67 4z" /></svg>
                                    </div>
                                </div>
                                <div class="flex flex-1 items-center justify-center p-3">
                                    <div class="relative h-12 w-16 rounded border border-dashed border-primary-500/50">
                                        <div
                                            class="absolute -left-px -top-px h-1.5 w-1.5 border-l border-t border-primary-500"
                                        ></div>
                                        <div
                                            class="absolute -right-px -top-px h-1.5 w-1.5 border-r border-t border-primary-500"
                                        ></div>
                                        <div
                                            class="absolute -bottom-px -left-px h-1.5 w-1.5 border-b border-l border-primary-500"
                                        ></div>
                                        <div
                                            class="absolute -bottom-px -right-px h-1.5 w-1.5 border-b border-r border-primary-500"
                                        ></div>
                                        <div class="flex h-full flex-col items-center justify-center">
                                            <svg class="h-3 w-3 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                            </svg>
                                            <p class="mt-0.5 text-[0.35rem] text-neutral-400">Position ID</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center py-2">
                                    <div class="h-4 w-4 rounded-full border-2 border-white/80 bg-white/10"></div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @else
                <div class="relative h-full w-full">
                    @if ($image)
                        <img
                            src="{{ asset($image) }}"
                            alt="{{ $imageAlt }}"
                            class="absolute inset-0 size-full object-cover object-bottom"
                        >
                        @if ($overlay === 'dark')
                            <div class="absolute inset-0 bg-black/40"></div>
                        @elseif ($overlay === 'light')
                            <div class="absolute inset-0 bg-white/30"></div>
                        @endif
                    @endif
                    <div class="relative h-full w-full">{{ $slot }}</div>
                </div>
            @endif
        </div>
    </div>
</div>
