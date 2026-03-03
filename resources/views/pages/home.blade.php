@extends('layouts.app')

@section('title', 'Verify Every Image. Eliminate Fraud.')
@section('description', 'PixaProof AI-powered verification detects image tampering in seconds—protecting your business from fraudulent claims, fake documents, and compliance failures.')

@section('content')
    {{-- Section 1: Hero --}}
    <section class="relative isolate overflow-hidden px-4 pt-24 pb-20 lg:pt-28 lg:pb-28">
        {{-- Background: Gradient + grid + noise --}}
        <div class="absolute inset-0 -z-10 noise-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-primary-50/50"></div>
            {{-- Grid pattern with gradient fade --}}
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0ea5e918_1px,transparent_1px),linear-gradient(to_bottom,#0ea5e918_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_80%)]"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Left: Copy --}}
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                    {{-- Eyebrow badge --}}
                    <span class="inline-flex items-center rounded border border-primary-500/40 bg-primary-500/10 px-3 py-1 text-xs font-medium font-heading uppercase tracking-wider text-primary-600 mb-6 transition-all duration-500"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                       Now Available
                    </span>

                    {{-- Headline with rotating industry keyword --}}
                    <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-neutral-900 tracking-tight mb-6 transition-all duration-500 delay-100"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Stop Fake Images From Entering Your
                        <span class="block"><x-rotating-text :words="['Item Lending', 'Insurance Claims', 'Product Delivery', 'eKYC Onboarding']" class="bg-gradient-to-r from-primary-500 to-primary-700 bg-clip-text text-transparent" /> Workflows.</span>
                    </h1>

                    {{-- Subheadline --}}
                    <p class="text-lg text-neutral-600 mb-10 max-w-xl leading-relaxed transition-all duration-500 delay-200"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Fraudulent images cost enterprises millions in false transactions. PixaProof's SDK secures photos at the moment of capture — cryptographically signed, tamper-proof, and verified before they ever reach your system.
                    </p>

                    {{-- Dual CTA --}}
                    <div class="flex flex-col sm:flex-row gap-4 transition-all duration-500 delay-300"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        <x-button href="{{ route('contact') }}" size="lg">
                            Book a Demo
                        </x-button>
                        <x-button href="#how-it-works" variant="outline" size="lg" class="border-neutral-300 text-neutral-700 hover:bg-neutral-100">
                            See How It Works
                            <x-heroicon-o-arrow-down class="w-4 h-4 ml-1" />
                        </x-button>
                    </div>
                </div>

                {{-- Right: Visual --}}
                <div class="hidden lg:block">
                    <x-graphics.hero-comparison />
                </div>
            </div>
        </div>
    </section>

    {{-- Section 2: Trust Strip --}}
    <section class="bg-neutral-100 border-y border-neutral-200 py-5"
        x-data="{ visible: false }" x-intersect.once="visible = true; $nextTick(() => Motion.staggerFadeIn($el.querySelectorAll('[data-trust-item]'), { stagger: 0.06, y: 10 }))">
        <div class="max-w-7xl mx-auto px-4">
            <p class="mb-4 text-xs text-center text-primary-700 font-bold uppercase tracking-wider mb-3">Built by one of ASEAN's top eKYC providers</p>
            <div class="flex items-center justify-between gap-8 overflow-x-auto py-1 text-sm font-heading font-medium text-neutral-600">
                <div data-trust-item class="flex items-center gap-2 whitespace-nowrap">
                    <x-heroicon-o-shield-check class="w-5 h-5 text-primary-600 shrink-0" />
                    <span>ISO 30107-3 Compliant</span>
                </div>
                <div data-trust-item class="flex items-center gap-2 whitespace-nowrap">
                    <x-heroicon-o-light-bulb class="w-5 h-5 text-primary-600 shrink-0" />
                    <span>3 Patents Granted</span>
                </div>
                <div data-trust-item class="flex items-center gap-2 whitespace-nowrap">
                    <x-heroicon-o-clock class="w-5 h-5 text-primary-600 shrink-0" />
                    <span>Since 2011</span>
                </div>
                <div data-trust-item class="flex items-center gap-2 whitespace-nowrap">
                    <x-heroicon-o-finger-print class="w-5 h-5 text-primary-600 shrink-0" />
                    <span>10M+ Verifications</span>
                </div>
                <div data-trust-item class="flex items-center gap-2 whitespace-nowrap">
                    <x-heroicon-o-globe-asia-australia class="w-5 h-5 text-primary-600 shrink-0" />
                    <span>10 ASEAN Countries</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 3: The Challenge — Scroll-Scrubable --}}
    <section id="challenge" data-scrub-section class="relative">
        {{-- Scroll runway: 6 phases × ~83vh each ≈ 500vh. Adjust if phases are added/removed. --}}
        <div class="h-auto md:h-[500vh]">
            {{-- Sticky viewport: pinned on desktop, normal flow on mobile --}}
            <div class="relative md:sticky md:top-16 md:h-[calc(100vh-4rem)] overflow-hidden flex items-center justify-center">
                {{-- Background color layer --}}
                <div data-scrub-bg class="absolute inset-0 bg-white"></div>

                {{-- Content viewport --}}
                <div data-scrub-viewport class="relative z-10 w-full max-w-4xl mx-auto px-4 text-neutral-900">

                    {{-- Phase: Title --}}
                    <div data-scrub-phase="title" class="py-16 md:py-0 md:absolute md:inset-0 md:flex md:flex-col md:items-center md:justify-center text-center md:will-change-[transform,opacity]">
                        <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">The Problem</p>
                        <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                            Every Manipulated Photo That Slips Through Has a Price
                        </h2>
                    </div>

                    {{-- Phase: Stats (one at a time on desktop, stacked on mobile) --}}
                    <div data-scrub-stat="0" class="py-12 md:py-0 md:absolute md:inset-0 md:flex md:flex-col md:items-center md:justify-center text-center md:will-change-[transform,opacity]">
                        <div class="font-heading text-7xl md:text-8xl lg:text-9xl font-bold text-red-500 mb-4">
                            <span data-scrub-counter data-target="90" data-suffix="%">0%</span>
                        </div>
                        <p class="text-lg md:text-xl max-w-3xl mx-auto opacity-90">of online content will be AI-generated by 2026. Without proof of origin and verification, nothing can be trusted. The question isn't whether you'll receive a fake — it's whether you have systems in place to catch it.</p>
                        <p class="text-xs opacity-50 mt-3">Source: Europol Innovation Lab; Nina Schick</p>
                    </div>

                    <div data-scrub-stat="1" class="py-12 md:py-0 md:absolute md:inset-0 md:flex md:flex-col md:items-center md:justify-center text-center md:will-change-[transform,opacity]">
                        <div class="font-heading text-7xl md:text-8xl lg:text-9xl font-bold text-amber-300 mb-4">
                            <span data-scrub-counter data-target="64" data-suffix="%">0%</span>
                        </div>
                        <p class="text-lg md:text-xl max-w-3xl mx-auto opacity-90">of claims handlers flag generative AI as a growing fraud risk. Claims backed by synthetic photos are already slipping through — and adjusters can't tell the difference.</p>
                        <p class="text-xs opacity-50 mt-3">Source: ITIJ Claims Handler Survey</p>
                    </div>

                    <div data-scrub-stat="2" class="py-12 md:py-0 md:absolute md:inset-0 md:flex md:flex-col md:items-center md:justify-center text-center md:will-change-[transform,opacity]">
                        <div class="font-heading text-7xl md:text-8xl lg:text-9xl font-bold mb-4">
                            <span data-scrub-counter data-target="30" data-suffix="%">0%</span>
                        </div>
                        <p class="text-lg md:text-xl max-w-3xl mx-auto opacity-90">of enterprises will drop standalone identity verification by 2026. When the source image itself is fabricated, downstream verification has nothing real to verify. Verification must begin at the point of capture.</p>
                        <p class="text-xs opacity-50 mt-3">Source: Gartner, Feb 2024</p>
                    </div>

                    {{-- Phase: Insight --}}
                    <div data-scrub-phase="insight" class="py-12 md:py-0 md:absolute md:inset-0 md:flex md:items-center md:justify-center md:will-change-[transform,opacity]">
                        <div class="max-w-2xl mx-auto border-l-4 border-primary-400 pl-8 relative">
                            <svg class="absolute -left-4 -top-8 w-16 h-16 text-primary-400/20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311C9.591 11.69 11 13.198 11 15c0 1.857-1.344 3.5-3.2 3.5-1.296 0-2.541-.673-3.217-1.179zm12 0C15.553 16.227 15 15 15 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311C21.591 11.69 23 13.198 23 15c0 1.857-1.344 3.5-3.2 3.5-1.296 0-2.541-.673-3.217-1.179z"/>
                            </svg>
                            <p class="font-heading text-2xl md:text-3xl font-bold leading-snug mb-4">
                                Verifying what is in an image is no longer enough — you must verify its origin.
                            </p>
                            <p class="text-lg leading-relaxed opacity-80">
                                Organizations currently store "blind" media with no verifiable link to the actual capture environment — leading to massive potential liability.
                            </p>
                        </div>
                    </div>

                    {{-- Phase: Gallery (attack vectors) --}}
                    <div data-scrub-phase="gallery" class="py-12 md:py-0 md:absolute md:inset-0 md:flex md:flex-col md:items-center md:justify-center md:will-change-[transform,opacity]">
                        <p class="text-red-400 font-heading font-semibold uppercase tracking-wider text-sm mb-3 text-center">Attack Vectors</p>
                        <h3 class="font-heading text-2xl md:text-3xl font-bold mb-8 text-center">5 Ways Fraudsters Exploit Your Photo Pipeline</h3>
                        <div class="flex flex-wrap justify-center gap-4 w-full [&>div]:w-full [&>div]:md:w-[calc(50%-0.5rem)] [&>div]:lg:w-[calc(33.333%-0.75rem)]">
                            <div data-scrub-card class="p-5 rounded-lg border border-white/10 bg-white/5 md:will-change-[transform,opacity]">
                                <x-heroicon-o-photo class="w-6 h-6 text-red-400 mb-3" />
                                <h4 class="font-heading font-semibold mb-1">Gallery uploads instead of live photos</h4>
                                <p class="text-sm opacity-80">Users upload pre-edited images from their camera roll — apps can't tell the difference</p>
                            </div>
                            <div data-scrub-card class="p-5 rounded-lg border border-white/10 bg-white/5 md:will-change-[transform,opacity]">
                                <x-heroicon-o-cpu-chip class="w-6 h-6 text-red-400 mb-3" />
                                <h4 class="font-heading font-semibold mb-1">AI-generated documents and deepfakes</h4>
                                <p class="text-sm opacity-80">Synthetic IDs, fake damage photos, and AI-altered evidence are now trivial to produce</p>
                            </div>
                            <div data-scrub-card class="p-5 rounded-lg border border-white/10 bg-white/5 md:will-change-[transform,opacity]">
                                <x-heroicon-o-video-camera class="w-6 h-6 text-red-400 mb-3" />
                                <h4 class="font-heading font-semibold mb-1">Virtual camera injection</h4>
                                <p class="text-sm opacity-80">Software-based virtual cameras bypass standard capture interfaces, injecting pre-recorded or AI-generated content</p>
                            </div>
                            <div data-scrub-card class="p-5 rounded-lg border border-white/10 bg-white/5 md:will-change-[transform,opacity]">
                                <x-heroicon-o-computer-desktop class="w-6 h-6 text-red-400 mb-3" />
                                <h4 class="font-heading font-semibold mb-1">Headless emulator attacks</h4>
                                <p class="text-sm opacity-80">Fraudsters use emulators to inject thousands of synthetic images simultaneously, bypassing device checks entirely</p>
                            </div>
                            <div data-scrub-card class="p-5 rounded-lg border border-white/10 bg-white/5 md:will-change-[transform,opacity]">
                                <x-heroicon-o-map-pin class="w-6 h-6 text-red-400 mb-3" />
                                <h4 class="font-heading font-semibold mb-1">Spoofed location and timestamp data</h4>
                                <p class="text-sm opacity-80">GPS and date metadata can be changed with free tools before submission</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Section 4: Before/After Comparison --}}
    <section class="relative py-20 lg:py-28 bg-neutral-50 border-y border-neutral-200"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        {{-- Subtle dot pattern --}}
        <div class="absolute inset-0 bg-[radial-gradient(#94a3b820_1px,transparent_1px)] bg-[size:1.5rem_1.5rem]"></div>
        <div class="relative max-w-6xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-16">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">The Difference</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    One Layer of Protection Changes Everything
                </h2>
                <p class="text-neutral-600 text-lg max-w-2xl mx-auto">
                    See what happens when you secure the capture point — the one moment traditional systems cannot verify.
                </p>
            </div>

            <x-graphics.prevention-visual />
        </div>
    </section>

    {{-- Section 5: Three Layers of Protection --}}
    <section id="solution" class="py-20 lg:py-28 bg-white"
        x-data="{ visible: false }" x-intersect.once="visible = true; $nextTick(() => Motion.staggerFadeIn($el.querySelectorAll('[data-layer-card]'), { stagger: 0.1, delay: 0.15 }))">
        <div class="max-w-7xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-16">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">The Solution</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    Three Layers of Protection in Every Image
                </h2>
                <p class="text-neutral-700 text-lg max-w-3xl mx-auto">
                    PixaProof doesn't just detect fraud after the fact — it prevents it at the source, then verifies every image through three independent checks.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-6 max-w-4xl mx-auto [&>div]:w-full [&>div]:md:w-[calc(50%-0.75rem)]">
                {{-- 1. Capture Integrity --}}
                <div data-layer-card class="p-6 bg-white rounded-lg border border-neutral-200 transition-transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                            <x-heroicon-o-camera class="w-5 h-5 text-primary-600" />
                        </div>
                        <h3 class="font-heading font-semibold text-neutral-900">Capture Integrity</h3>
                    </div>
                    <p class="text-neutral-600">Flags virtual camera drivers, emulator sessions, and automated scripts. Gallery uploads, screenshots, and file injections are detected and flagged — with full capture environment forensics on every submission.</p>
                </div>

                {{-- 2. Source Protection --}}
                <div data-layer-card class="p-6 bg-white rounded-lg border border-neutral-200 transition-transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-primary-600" />
                        </div>
                        <h3 class="font-heading font-semibold text-neutral-900">Source Protection</h3>
                    </div>              <p class="text-neutral-600">Images are sealed with an invisible, tamper-evident digital watermark. The system binds media to its environmental data — making unauthorized edits or alterations significantly harder.</p>
                </div>

                {{-- 3. AI & Tampering Detection --}}
                <div data-layer-card class="p-6 bg-white rounded-lg border border-neutral-200 transition-transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-primary-600" />
                        </div>
                        <h3 class="font-heading font-semibold text-neutral-900">AI & Tampering Detection</h3>
                    </div>
                    <p class="text-neutral-600">Identifies synthetic media injection, AI-generated content, and pixel-level manipulation that manual review would miss.</p>
                </div>

            </div>

            {{-- Summary card --}}
            <div data-layer-card class="mt-6 p-6 bg-primary-600 rounded-lg text-white max-w-4xl mx-auto">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                        <x-heroicon-o-bolt class="w-5 h-5 text-white" />
                    </div>
                    <h3 class="font-heading font-semibold">All in Under 500ms</h3>
                </div>
                <p class="text-primary-100">Every image runs through all three checks automatically — results returned via Web SDK and API before your user finishes the next step.</p>
            </div>
        </div>
    </section>

    {{-- Section 6: How It Works --}}
    <section id="how-it-works" class="py-20 lg:py-28 bg-primary-50/50 border-t border-primary-100"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        <div class="max-w-5xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-16">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">How It Works</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    Three Steps to Verified Evidence
                </h2>
                <p class="text-pretty text-neutral-600 text-lg max-w-2xl mx-auto">
                    Embed our Web SDK in your application. From the moment of capture to your API response — PixaProof secures, transmits, and verifies every image automatically.
                </p>
            </div>

            <x-graphics.solution-flow />
        </div>
    </section>

    {{-- Section 7: Industry Solutions (Tabbed) --}}
    <section id="solutions" class="py-20 lg:py-28 bg-neutral-50"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        <div class="max-w-7xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-12">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">Applications</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    Built for the Industries That Need It Most
                </h2>
            </div>

            {{-- Tabbed Interface --}}
            <div x-data="{ activeTab: 'loan-draw' }">
                {{-- Tab Navigation - Desktop with underline indicator --}}
                <div class="hidden md:flex gap-3 mb-8">
                    <button
                        @click="activeTab = 'loan-draw'"
                        :class="activeTab === 'loan-draw' ? 'border-primary-500 bg-primary-50 text-primary-700 border-b-2 border-b-primary-600' : 'border-neutral-200 bg-white text-neutral-600 hover:border-neutral-300 hover:bg-neutral-50'"
                        class="flex items-center gap-2 px-5 py-3 text-sm font-heading font-semibold border rounded-lg transition-colors"
                    >
                        <x-heroicon-o-building-library class="w-4 h-4" />
                        Loan Draw Inspections
                    </button>
                    <button
                        @click="activeTab = 'insurance'"
                        :class="activeTab === 'insurance' ? 'border-primary-500 bg-primary-50 text-primary-700 border-b-2 border-b-primary-600' : 'border-neutral-200 bg-white text-neutral-600 hover:border-neutral-300 hover:bg-neutral-50'"
                        class="flex items-center gap-2 px-5 py-3 text-sm font-heading font-semibold border rounded-lg transition-colors"
                    >
                        <x-heroicon-o-shield-exclamation class="w-4 h-4" />
                        Insurance Claims
                    </button>
                    <button
                        @click="activeTab = 'kyc'"
                        :class="activeTab === 'kyc' ? 'border-primary-500 bg-primary-50 text-primary-700 border-b-2 border-b-primary-600' : 'border-neutral-200 bg-white text-neutral-600 hover:border-neutral-300 hover:bg-neutral-50'"
                        class="flex items-center gap-2 px-5 py-3 text-sm font-heading font-semibold border rounded-lg transition-colors"
                    >
                        <x-heroicon-o-identification class="w-4 h-4" />
                        KYC Onboarding
                    </button>
                    <button
                        @click="activeTab = 'asset'"
                        :class="activeTab === 'asset' ? 'border-primary-500 bg-primary-50 text-primary-700 border-b-2 border-b-primary-600' : 'border-neutral-200 bg-white text-neutral-600 hover:border-neutral-300 hover:bg-neutral-50'"
                        class="flex items-center gap-2 px-5 py-3 text-sm font-heading font-semibold border rounded-lg transition-colors"
                    >
                        <x-heroicon-o-cube class="w-4 h-4" />
                        Field Operations & Assets
                    </button>
                </div>

                {{-- Mobile: Accordion --}}
                <div class="md:hidden space-y-3">
                    <button @click="activeTab = activeTab === 'loan-draw' ? '' : 'loan-draw'"
                        :class="activeTab === 'loan-draw' ? 'border-primary-500 bg-primary-50' : 'border-neutral-200'"
                        class="w-full px-4 py-3 text-left font-semibold text-neutral-900 flex items-center justify-between border rounded-lg transition-colors">
                        <span class="flex items-center gap-2"><x-heroicon-o-building-library class="w-4 h-4 text-primary-600" /> Loan Draw Inspections</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform" x-bind:class="activeTab === 'loan-draw' ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="activeTab === 'loan-draw'" x-collapse class="px-4 pb-4">
                        <div class="text-2xl font-bold text-primary-600 mb-2">Cut Site Visit Costs with Verified Photo Evidence</div>
                        <p class="text-neutral-700 mb-4">Replace physical site visits with verified progress photos. Confirm images were captured on-site with authenticated GPS and timestamps — not uploaded from a gallery.</p>
                        <ul class="space-y-2 text-neutral-700">
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Verified progress photos with authenticated timestamps and GPS</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Live capture enforced — gallery uploads blocked</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Detection of recycled or manipulated construction photos</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Auditable documentation for loan file compliance</li>
                        </ul>
                    </div>

                    <button @click="activeTab = activeTab === 'insurance' ? '' : 'insurance'"
                        :class="activeTab === 'insurance' ? 'border-primary-500 bg-primary-50' : 'border-neutral-200'"
                        class="w-full px-4 py-3 text-left font-semibold text-neutral-900 flex items-center justify-between border rounded-lg transition-colors">
                        <span class="flex items-center gap-2"><x-heroicon-o-shield-exclamation class="w-4 h-4 text-primary-600" /> Insurance Claims</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform" x-bind:class="activeTab === 'insurance' ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="activeTab === 'insurance'" x-collapse class="px-4 pb-4">
                        <div class="text-2xl font-bold text-primary-600 mb-2">Flag suspicious claims before payout</div>
                        <p class="text-neutral-700 mb-4">Automatically verify claim photos were taken at the reported location and time. Detect AI-generated damage documentation and altered evidence.</p>
                        <ul class="space-y-2 text-neutral-700">
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Instant verification of claim photo authenticity</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> AI-generated and altered damage documentation flagged</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Geolocation matches reported incident location</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Reduced SIU referral backlog through automated flagging</li>
                        </ul>
                    </div>

                    <button @click="activeTab = activeTab === 'kyc' ? '' : 'kyc'"
                        :class="activeTab === 'kyc' ? 'border-primary-500 bg-primary-50' : 'border-neutral-200'"
                        class="w-full px-4 py-3 text-left font-semibold text-neutral-900 flex items-center justify-between border rounded-lg transition-colors">
                        <span class="flex items-center gap-2"><x-heroicon-o-identification class="w-4 h-4 text-primary-600" /> KYC Onboarding</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform" x-bind:class="activeTab === 'kyc' ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="activeTab === 'kyc'" x-collapse class="px-4 pb-4">
                        <div class="text-2xl font-bold text-primary-600 mb-2">Stop synthetic IDs at the source</div>
                        <p class="text-neutral-700 mb-4">Verify identity documents are photographed live — not uploaded from a gallery or generated by AI. Block fraudulent onboarding before it enters your system.</p>
                        <ul class="space-y-2 text-neutral-700">
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> ID photos confirmed as live capture, not uploaded</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Document tampering and digital manipulation detected</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Capture environment metadata bound to each session for fraud risk scoring</li>
                        </ul>
                    </div>

                    <button @click="activeTab = activeTab === 'asset' ? '' : 'asset'"
                        :class="activeTab === 'asset' ? 'border-primary-500 bg-primary-50' : 'border-neutral-200'"
                        class="w-full px-4 py-3 text-left font-semibold text-neutral-900 flex items-center justify-between border rounded-lg transition-colors">
                        <span class="flex items-center gap-2"><x-heroicon-o-cube class="w-4 h-4 text-primary-600" /> Field Operations & Assets</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform" x-bind:class="activeTab === 'asset' ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="activeTab === 'asset'" x-collapse class="px-4 pb-4">
                        <div class="text-2xl font-bold text-primary-600 mb-2">Verify what exists, where it exists</div>
                        <p class="text-neutral-700 mb-4">Confirm collateral and inventory documentation with timestamped, geolocated photography that can't be recycled or manipulated.</p>
                        <ul class="space-y-2 text-neutral-700">
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Timestamped, geolocated asset photography</li>
                            <li class="flex items-start gap-2"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Photo manipulation and staging detection</li>
                        </ul>
                    </div>
                </div>

                {{-- Tab Content - Desktop --}}
                <div class="hidden md:block">
                    {{-- Loan Draw Inspections --}}
                    <div x-show="activeTab === 'loan-draw'" x-transition class="grid lg:grid-cols-5 gap-8 items-start bg-white rounded-lg border border-neutral-200 p-8">
                        <div class="lg:col-span-3">
                            <div class="font-heading text-2xl font-bold text-primary-600 mb-3">Cut Site Visit Costs with Verified Photo Evidence</div>
                            <h3 class="text-xl font-semibold text-neutral-900 mb-4">Construction Verification Without Site Visits</h3>
                            <p class="text-neutral-700 mb-6">Replace physical site visits with verified progress photos. Lenders can confirm images were captured on-site with authenticated GPS and timestamps — not uploaded from a gallery or recycled from a previous draw.</p>
                            <ul class="space-y-3 text-neutral-700">
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Verified progress photos with authenticated timestamps and GPS</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Live capture enforced — gallery uploads blocked at SDK level</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Detection of recycled or manipulated construction photos</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Auditable documentation for loan file compliance</li>
                            </ul>
                        </div>
                        <div class="lg:col-span-2 flex justify-center">
                            <x-graphics.phone-mockup variant="default" size="lg" image="images/mockups/loan-draw-construction.webp?v=2" imageAlt="Construction site progress photo" />
                        </div>
                    </div>

                    {{-- Insurance Claims --}}
                    <div x-show="activeTab === 'insurance'" x-transition class="grid lg:grid-cols-5 gap-8 items-start bg-white rounded-lg border border-neutral-200 p-8">
                        <div class="lg:col-span-3">
                            <div class="font-heading text-2xl font-bold text-primary-600 mb-3">Deepfake fraud attempts up 2,137% in three years</div>
                            <p class="text-xs text-neutral-500 mb-1">— Signicat, <em>The Battle Against AI-Driven Identity Fraud</em>, 2024</p>
                            <h3 class="text-xl font-semibold text-neutral-900 mb-4">Accelerate Legitimate Claims. Flag Suspicious Submissions.</h3>
                            <p class="text-neutral-700 mb-6">Automatically verify claim photos were taken at the reported location and time. Detect AI-generated damage documentation and altered evidence before it reaches an adjuster.</p>
                            <ul class="space-y-3 text-neutral-700">
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Instant verification of claim photo authenticity</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> AI-generated and altered damage documentation flagged</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Geolocation confirmation matching reported incident location</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Reduced SIU referral backlog through automated flagging</li>
                            </ul>
                        </div>
                        <div class="lg:col-span-2 flex justify-center">
                            <x-graphics.phone-mockup variant="default" size="lg" image="images/mockups/insurance-car-damage.webp?v=2" imageAlt="Insurance claim damage photo" />
                        </div>
                    </div>

                    {{-- KYC Onboarding --}}
                    <div x-show="activeTab === 'kyc'" x-transition class="grid lg:grid-cols-5 gap-8 items-start bg-white rounded-lg border border-neutral-200 p-8">
                        <div class="lg:col-span-3">
                            <div class="font-heading text-2xl font-bold text-primary-600 mb-3">Stop synthetic IDs at the source</div>
                            <h3 class="text-xl font-semibold text-neutral-900 mb-4">Document Authentication at Point of Capture</h3>
                            <p class="text-neutral-700 mb-6">By 2026, 30% of enterprises will no longer consider standalone identity verification reliable in isolation (Gartner). Verify identity documents are photographed live — not uploaded from a gallery or generated by AI.</p>
                            <ul class="space-y-3 text-neutral-700">
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> ID photos confirmed as live capture, not uploaded</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Document tampering and digital manipulation detected</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Capture environment metadata bound to each session for fraud risk scoring</li>
                            </ul>
                        </div>
                        <div class="lg:col-span-2 flex justify-center">
                            <x-graphics.phone-mockup variant="default" size="lg" image="images/mockups/kyc-id-document.webp?v=2" imageAlt="KYC identity document verification" />
                        </div>
                    </div>

                    {{-- Asset Verification --}}
                    <div x-show="activeTab === 'asset'" x-transition class="grid lg:grid-cols-5 gap-8 items-start bg-white rounded-lg border border-neutral-200 p-8">
                        <div class="lg:col-span-3">
                            <div class="font-heading text-2xl font-bold text-primary-600 mb-3">Verify what exists, where it exists</div>
                            <h3 class="text-xl font-semibold text-neutral-900 mb-4">Authenticated Evidence for Field Operations & Assets</h3>
                            <p class="text-neutral-700 mb-6">From proof of delivery to car rental damage inspection to property listings — confirm field documentation with timestamped, geolocated photography that can't be recycled or manipulated.</p>
                            <ul class="space-y-3 text-neutral-700">
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Timestamped, geolocated asset photography</li>
                                <li class="flex items-start gap-3"><x-heroicon-s-check class="w-5 h-5 text-primary-600 mt-0.5 shrink-0" /> Photo manipulation and staging detection</li>
                            </ul>
                        </div>
                        <div class="lg:col-span-2 flex justify-center">
                            <x-graphics.phone-mockup variant="default" size="lg" image="images/mockups/asset-warehouse.webp?v=2" imageAlt="Asset warehouse inventory verification" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- And more --}}
            <p class="text-center text-sm text-neutral-500 mt-8">
                Also used for: marketplace item verification, property listings, vehicle ownership, and site inspections.
            </p>
        </div>
    </section>

    {{-- Section 8: Statistics Strip --}}
    <section class="relative py-16 bg-primary-600 noise-overlay"
        x-data="{ visible: false }"
        x-intersect.once="visible = true"
    >
        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="font-heading text-4xl md:text-5xl font-bold text-white mb-2"
                        x-show="visible"
                        x-transition
                        x-init="$watch('visible', v => { if (v) Motion.animateCounter($el, 10, 'M+') })">0</div>
                    <div class="text-primary-100 font-heading text-sm uppercase tracking-wider">Verifications Processed</div>
                </div>
                <div>
                    <div class="font-heading text-4xl md:text-5xl font-bold text-white mb-2"
                        x-show="visible"
                        x-transition
                        x-text="visible ? '<500ms' : '0'">0</div>
                    <div class="text-primary-100 font-heading text-sm uppercase tracking-wider">Verification Speed</div>
                </div>
                <div>
                    <div class="font-heading text-4xl md:text-5xl font-bold text-white mb-2"
                        x-show="visible"
                        x-transition
                        x-init="$watch('visible', v => { if (v) Motion.animateCounter($el, 35, '+') })">0</div>
                    <div class="text-primary-100 font-heading text-sm uppercase tracking-wider">Integrity Checks</div>
                </div>
                <div>
                    <div class="font-heading text-4xl md:text-5xl font-bold text-white mb-2"
                        x-show="visible"
                        x-transition
                        x-init="$watch('visible', v => { if (v) Motion.animateCounter($el, 3, '') })">0</div>
                    <div class="text-primary-100 font-heading text-sm uppercase tracking-wider">Granted Patents</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 9: Technology Highlights (Bento Grid) — COMMENTED OUT: data accuracy under review --}}
    @if(false)
    <section id="technology" class="py-20 lg:py-28 bg-white"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        <div class="max-w-7xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-12">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">Technology</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    Enterprise-Grade Infrastructure You Can Trust
                </h2>
            </div>

            {{-- Bento Grid --}}
            <div class="grid md:grid-cols-3 gap-6">
                {{-- Large card: API Response Preview --}}
                <div class="md:col-span-2 md:row-span-2 p-8 bg-white rounded-lg border border-neutral-200 transition-shadow hover:shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-primary-100 flex items-center justify-center">
                            <x-heroicon-o-check-badge class="w-7 h-7 text-primary-600" />
                        </div>
                        <div>
                            <h3 class="font-heading text-xl font-bold text-neutral-900">Results in Under 500 Milliseconds</h3>
                            <p class="text-sm text-neutral-500 flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-primary-500"></span></span>
                                35+ checks, one API call
                            </p>
                        </div>
                    </div>
                    {{-- API Response mockup --}}
                    <div class="rounded-lg bg-neutral-900 p-5 font-mono text-sm leading-relaxed overflow-x-auto">
                        <div class="text-neutral-500">// POST /api/v1/verify</div>
                        <div class="mt-2 text-neutral-300">{</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">authenticity_status</span>": "<span class="text-green-400">verified</span>",</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">capture_confidence</span>": <span class="text-amber-400">0.98</span>,</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">live_capture</span>": <span class="text-green-400">true</span>,</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">ai_generated</span>": <span class="text-red-400">false</span>,</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">tampering_detected</span>": <span class="text-red-400">false</span>,</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">gps_verified</span>": <span class="text-green-400">true</span>,</div>
                        <div class="ml-4 text-neutral-300">"<span class="text-primary-400">processing_time_ms</span>": <span class="text-amber-400">347</span></div>
                        <div class="text-neutral-300">}</div>
                    </div>
                </div>

                {{-- Medium card: Web SDK --}}
                <div class="p-6 bg-white rounded-lg border border-neutral-200 transition-shadow hover:shadow-md">
                    <div class="w-12 h-12 mb-4 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-code-bracket class="w-6 h-6 text-primary-600" />
                    </div>
                    <h3 class="font-heading text-lg font-semibold text-neutral-900 mb-2">Web SDK — Integrate in Hours</h3>
                    <p class="text-sm text-neutral-600">Browser-based SDK handles camera, location, and motion sensor access within your user flow. The capture interface is customizable to match your brand identity.</p>
                </div>

                {{-- Medium card: Real-Time Processing --}}
                <div class="p-6 bg-white rounded-lg border border-neutral-200 transition-shadow hover:shadow-md">
                    <div class="w-12 h-12 mb-4 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-bolt class="w-6 h-6 text-primary-600" />
                    </div>
                    <h3 class="font-heading text-lg font-semibold text-neutral-900 mb-2">Real-Time, Not Batch</h3>
                    <p class="text-sm text-neutral-600">Verification results returned via REST API before your user finishes the next step. No queues, no delays.</p>
                </div>

                {{-- Small card: On-Premise --}}
                <div class="p-6 bg-white rounded-lg border border-neutral-200 transition-shadow hover:shadow-md">
                    <div class="w-10 h-10 mb-3 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-server class="w-5 h-5 text-primary-600" />
                    </div>
                    <h3 class="font-heading text-base font-semibold text-neutral-900 mb-1">On-Premise Available</h3>
                    <p class="text-sm text-neutral-600">Deploy in your own infrastructure for data residency and air-gapped environments.</p>
                </div>

                {{-- Small card: API-First --}}
                <div class="p-6 bg-white rounded-lg border border-neutral-200 transition-shadow hover:shadow-md">
                    <div class="w-10 h-10 mb-3 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-command-line class="w-5 h-5 text-primary-600" />
                    </div>
                    <h3 class="font-heading text-base font-semibold text-neutral-900 mb-1">API-First Architecture</h3>
                    <p class="text-sm text-neutral-600">During verification, our API checks hidden data sealed during capture to flag whether the session was genuine or suspicious.</p>
                </div>

                {{-- Small card: Roadmap --}}
                <div class="p-6 bg-white rounded-lg border border-neutral-200 transition-shadow hover:shadow-md">
                    <div class="w-10 h-10 mb-3 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-map class="w-5 h-5 text-primary-600" />
                    </div>
                    <h3 class="font-heading text-base font-semibold text-neutral-900 mb-1">Roadmap</h3>
                    <p class="text-sm text-neutral-600">Mobile SDKs for iOS & Android, deeper capture environment intelligence, and video support — coming soon.</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Section 10: Comparison Table --}}
    <section class="py-20 lg:py-28 bg-neutral-50"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        <div class="max-w-5xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-12">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">Why PixaProof</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    How We Compare
                </h2>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-hidden rounded-lg border border-neutral-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-neutral-100">
                            <th class="px-6 py-4 text-left font-heading font-semibold text-neutral-900">Capability</th>
                            <th class="px-6 py-4 text-center font-heading font-semibold text-neutral-500">Manual Review</th>
                            <th class="px-6 py-4 text-center font-heading font-semibold text-primary-700 bg-primary-100 border-l-2 border-l-primary-500">PixaProof</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Detect gallery uploads</td>
                            <td class="px-6 py-4 text-center"><x-heroicon-o-x-mark class="w-5 h-5 text-red-400 mx-auto" /></td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Detect virtual cameras</td>
                            <td class="px-6 py-4 text-center"><x-heroicon-o-x-mark class="w-5 h-5 text-red-400 mx-auto" /></td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Detect emulator attacks</td>
                            <td class="px-6 py-4 text-center"><x-heroicon-o-x-mark class="w-5 h-5 text-red-400 mx-auto" /></td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Verify GPS authenticity</td>
                            <td class="px-6 py-4 text-center"><x-heroicon-o-x-mark class="w-5 h-5 text-red-400 mx-auto" /></td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Detect AI-generated content</td>
                            <td class="px-6 py-4 text-center"><x-heroicon-o-x-mark class="w-5 h-5 text-red-400 mx-auto" /></td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Detect pixel-level edits</td>
                            <td class="px-6 py-4 text-center text-neutral-500">Subjective</td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">End-to-end integrity (MITM)</td>
                            <td class="px-6 py-4 text-center"><x-heroicon-o-x-mark class="w-5 h-5 text-red-400 mx-auto" /></td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500"><x-heroicon-s-check class="w-5 h-5 text-green-500 mx-auto" /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-neutral-700">Time to verify</td>
                            <td class="px-6 py-4 text-center text-neutral-500">Hours–Days</td>
                            <td class="px-6 py-4 text-center bg-primary-50 border-l-2 border-l-primary-500 font-semibold text-primary-700">&lt;500ms</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Mobile: Stacked cards --}}
            <div class="md:hidden space-y-4"
                x-intersect.once="$nextTick(() => Motion.staggerFadeIn($el.children, { stagger: 0.06, y: 15 }))">
                @php
                    $comparisons = [
                        ['label' => 'Detect gallery uploads', 'manual' => 'No', 'pixaproof' => 'Yes'],
                        ['label' => 'Detect virtual cameras', 'manual' => 'No', 'pixaproof' => 'Yes'],
                        ['label' => 'Detect emulator attacks', 'manual' => 'No', 'pixaproof' => 'Yes'],
                        ['label' => 'Verify GPS authenticity', 'manual' => 'No', 'pixaproof' => 'Yes'],
                        ['label' => 'Detect AI content', 'manual' => 'No', 'pixaproof' => 'Yes'],
                        ['label' => 'Detect pixel edits', 'manual' => 'Subjective', 'pixaproof' => 'Yes'],
                        ['label' => 'End-to-end integrity', 'manual' => 'No', 'pixaproof' => 'Yes'],
                        ['label' => 'Time to verify', 'manual' => 'Hours', 'pixaproof' => '<500ms'],
                    ];
                @endphp
                @foreach($comparisons as $row)
                    <div class="rounded-lg border border-neutral-200 p-4">
                        <div class="font-semibold text-neutral-900 mb-3">{{ $row['label'] }}</div>
                        <div class="grid grid-cols-2 gap-2 text-center text-sm">
                            <div>
                                <div class="text-neutral-500 text-xs mb-1">Manual</div>
                                <div class="text-neutral-600">{{ $row['manual'] }}</div>
                            </div>
                            <div class="bg-primary-50 rounded p-1">
                                <div class="text-primary-600 text-xs mb-1 font-semibold">PixaProof</div>
                                <div class="text-primary-700 font-semibold">{{ $row['pixaproof'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 11: Credibility / Heritage --}}
    <section id="about" class="py-20 lg:py-28 bg-neutral-100"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        <div class="max-w-7xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-16">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">Proven Expertise</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                    Built by Southeast Asia's Most Experienced Identity Verification Team
                </h2>
                <p class="text-neutral-600 text-lg max-w-3xl mx-auto">
                    PixaProof is developed by MyNasional eKYC (formerly Innov8tif Solutions), Southeast Asia's largest identity assurance provider. Over a decade of experience securing identity workflows for banks, insurers, and government agencies across ASEAN.
                </p>
            </div>

            {{-- Timeline --}}
            <div class="relative mb-16">
                {{-- Connecting line (desktop) with gradient pulse --}}
                <div class="hidden md:block absolute top-6 left-0 right-0 h-0.5 bg-gradient-to-r from-primary-300 via-primary-500 to-primary-300 bg-[length:200%_100%] animate-[shimmer_3s_ease-in-out_infinite]"></div>

                <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
                    @php
                        $milestones = [
                            ['year' => '2011', 'label' => 'Founded as Innov8tif', 'icon' => 'flag'],
                            ['year' => '2019', 'label' => 'ISO 30107-3 Certified', 'icon' => 'shield-check'],
                            ['year' => '2020', 'label' => 'US Patent Granted', 'icon' => 'light-bulb'],
                            ['year' => '2023', 'label' => 'NexG / Bursa Listed', 'icon' => 'building-office'],
                            ['year' => '2024', 'label' => '10M+ Verifications', 'icon' => 'finger-print'],
                            ['year' => '2025', 'label' => 'PixaProof Launches', 'icon' => 'rocket-launch'],
                        ];
                    @endphp
                    @foreach($milestones as $m)
                        <div class="text-center relative">
                            <div class="relative z-10 w-12 h-12 mx-auto mb-3 rounded-full bg-white border-2 border-primary-500 flex items-center justify-center">
                                @if($m['icon'] === 'flag')
                                    <x-heroicon-o-flag class="w-5 h-5 text-primary-600" />
                                @elseif($m['icon'] === 'shield-check')
                                    <x-heroicon-o-shield-check class="w-5 h-5 text-primary-600" />
                                @elseif($m['icon'] === 'light-bulb')
                                    <x-heroicon-o-light-bulb class="w-5 h-5 text-primary-600" />
                                @elseif($m['icon'] === 'building-office')
                                    <x-heroicon-o-building-office class="w-5 h-5 text-primary-600" />
                                @elseif($m['icon'] === 'finger-print')
                                    <x-heroicon-o-finger-print class="w-5 h-5 text-primary-600" />
                                @elseif($m['icon'] === 'rocket-launch')
                                    <x-heroicon-o-rocket-launch class="w-5 h-5 text-primary-600" />
                                @endif
                            </div>
                            <div class="font-heading text-lg font-bold text-neutral-900">{{ $m['year'] }}</div>
                            <div class="text-sm text-neutral-600 mt-1">{{ $m['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Certifications Row --}}
            <div class="grid sm:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-white border border-neutral-200 rounded-lg transition-transform hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-shield-check class="w-6 h-6 text-primary-600" />
                    </div>
                    <h3 class="font-heading font-semibold text-neutral-900 mb-1">ISO 30107-3</h3>
                    <p class="text-sm text-neutral-600">iBeta Level 1 & 2 Liveness Compliance</p>
                </div>
                <div class="text-center p-6 bg-white border border-neutral-200 rounded-lg transition-transform hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-light-bulb class="w-6 h-6 text-primary-600" />
                    </div>
                    <h3 class="font-heading font-semibold text-neutral-900 mb-1">3 Patents</h3>
                    <p class="text-sm text-neutral-600">Including US patent for hologram detection</p>
                </div>
                <div class="text-center p-6 bg-white border border-neutral-200 rounded-lg transition-transform hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-lg bg-primary-100 flex items-center justify-center">
                        <x-heroicon-o-building-office class="w-6 h-6 text-primary-600" />
                    </div>
                    <h3 class="font-heading font-semibold text-neutral-900 mb-1">Bursa Malaysia Listed</h3>
                    <p class="text-sm text-neutral-600">Part of NexG Bhd. public-listed group</p>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="https://innov8tif.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 transition-colors">
                    Learn more about our parent company
                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                </a>
            </div>
        </div>
    </section>

    {{-- Section 12: FAQ --}}
    <section id="faq" class="py-20 lg:py-28 bg-white"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        <div class="max-w-3xl mx-auto px-4 transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-12">
                <p class="text-primary-600 font-heading font-semibold uppercase tracking-wider text-sm mb-4">FAQ</p>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900">
                    Frequently Asked Questions
                </h2>
            </div>

            {{-- Accordion --}}
            <div x-data="{ openFaq: null }" class="space-y-3">
                @php
                    $faqs = [
                        [
                            'q' => 'How does PixaProof integrate with existing systems?',
                            'a' => 'PixaProof provides a browser-based Web SDK and REST API. The Web SDK manages camera, location, and motion sensor permissions within your user flow. Integration involves embedding a JavaScript SDK and connecting verification results to your backend via API. Basic integration takes hours. Mobile SDKs for iOS and Android are on the roadmap.',
                        ],
                        [
                            'q' => 'How does PixaProof detect AI-generated images?',
                            'a' => 'Our verification engine runs 35+ checks including pixel-level analysis, metadata consistency verification, and purpose-built AI detection models trained on millions of synthetic and authentic images. The system identifies deepfakes, AI-generated documents, and digitally altered evidence with high confidence.',
                        ],
                        [
                            'q' => 'What is PIEA and how does it work?',
                            'a' => 'PIEA (Photo Integrity Encoding Algorithm) is our proprietary system that seals each capture with a tamper-evident digital watermark. At the moment of capture, the SDK binds the image to its environmental data — device, timestamp, GPS, and browser metadata. During verification, the server checks whether these sealed values remain consistent. This raises the bar significantly against tampering, making unauthorized alterations much harder to execute undetected.',
                        ],
                        [
                            'q' => 'Can PixaProof work with our existing mobile app?',
                            'a' => 'Currently, PixaProof offers a Web SDK that works in mobile browsers within your app\'s webview or standalone. Native mobile SDKs for iOS and Android are on our roadmap. Your users capture photos through the browser — PixaProof runs the verification automatically.',
                        ],
                        [
                            'q' => 'What deployment options are available?',
                            'a' => 'We offer a fully managed, cloud-hosted (SaaS) API. By handling the backend infrastructure on our end, we ensure you always have access to our fastest, most up-to-date verification capabilities with zero maintenance required on your side.',
                        ],
                        [
                            'q' => 'What happens when manipulation is detected?',
                            'a' => 'The API response indicates the verification as failed and provides supplementary information on geolocation.',
                        ],
                        [
                            'q' => 'What metadata does PixaProof collect?',
                            'a' => 'Browser-related metadata, location, timestamp, and device environment data — linked to the image at the moment of capture. All metadata is used exclusively for verification purposes.',
                        ],
                        [
                            'q' => 'What industries does PixaProof serve?',
                            'a' => 'PixaProof is built for any industry that relies on user-submitted photographic evidence: banking and lending (loan draw inspections, KYC), insurance (claims verification), delivery and field operations (proof of delivery, inspections), real estate, and e-commerce (product verification, returns).',
                        ],
                        [
                            'q' => 'How is data handled and protected?',
                            'a' => 'PixaProof supports international data protection standards including GDPR. Verification metadata retention is configurable per organizational policy. All data is encrypted in transit (TLS 1.3) and at rest.',
                        ],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="border border-neutral-200 rounded-lg overflow-hidden transition-colors"
                        :class="openFaq === {{ $index + 1 }} ? 'border-l-2 border-l-primary-500' : ''">
                        <button
                            @click="openFaq = openFaq === {{ $index + 1 }} ? null : {{ $index + 1 }}"
                            class="w-full px-6 py-4 text-left font-heading font-semibold text-neutral-900 bg-white hover:bg-neutral-50 flex justify-between items-center gap-4 transition-colors"
                        >
                            {{ $faq['q'] }}
                            <x-heroicon-o-chevron-down class="w-5 h-5 text-neutral-500 transition-transform shrink-0" x-bind:class="openFaq === {{ $index + 1 }} ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="openFaq === {{ $index + 1 }}" x-collapse class="px-6 py-4 bg-neutral-50 border-t border-neutral-200">
                            <p class="text-neutral-700 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 13: Final CTA --}}
    <section class="relative py-20 lg:py-28 bg-gradient-to-b from-primary-50 to-primary-100 overflow-hidden"
        x-data="{ visible: false }" x-intersect.once="visible = true">
        {{-- Radial dot pattern --}}
        <div class="absolute inset-0 bg-[radial-gradient(#0ea5e915_1.5px,transparent_1.5px)] bg-[size:2rem_2rem] [mask-image:radial-gradient(ellipse_at_center,black_30%,transparent_70%)]"></div>
        <div class="relative max-w-4xl mx-auto px-4 text-center transition-all duration-700 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="font-heading text-3xl md:text-4xl font-bold text-neutral-900 mb-6">
                Every Unverified Image Is a Liability
            </h2>
            <p class="text-xl text-neutral-600 mb-10 max-w-2xl mx-auto">
                Watch PixaProof verify live captures in under 500ms. Integrate our Web SDK in hours.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <x-button href="{{ route('contact') }}" size="lg">
                    Book a Demo
                </x-button>
                <x-button href="mailto:sales@innov8tif.com" variant="outline" size="lg" class="border-neutral-300 text-neutral-700 hover:bg-neutral-100">
                    Email Sales Team
                </x-button>
            </div>

            <p class="mt-10 text-sm text-neutral-500">
                Trusted by the team behind 10M+ identity verifications across ASEAN
            </p>
        </div>
    </section>
@endsection
