@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('description', 'PixaProof privacy policy — how we collect, use, and protect your data when using our image verification platform.')

@section('content')
    <section class="py-20">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-neutral-900">Privacy Policy</h1>
            <p class="mt-4 text-sm text-neutral-500">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-lg mt-8">
                <h2 class="text-2xl font-semibold text-neutral-900">Introduction</h2>
                <p class="text-neutral-700">
                    PixaProof ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy
                    explains how we collect, use, and safeguard your information when you use our mobile application.
                </p>

                <h2 class="mt-8 text-2xl font-semibold text-neutral-900">Information We Collect</h2>
                <p class="text-neutral-700">When you use PixaProof, we may collect:</p>
                <ul class="list-disc pl-6 text-neutral-700">
                    <li>Images you submit for verification (processed in real-time, not stored)</li>
                    <li>Device information for app functionality</li>
                    <li>Usage analytics to improve our service</li>
                </ul>

                <h2 class="mt-8 text-2xl font-semibold text-neutral-900">How We Use Your Information</h2>
                <p class="text-neutral-700">We use the information we collect to:</p>
                <ul class="list-disc pl-6 text-neutral-700">
                    <li>Provide photo authenticity verification services</li>
                    <li>Improve and optimize our application</li>
                    <li>Respond to your inquiries and support requests</li>
                </ul>

                <h2 class="mt-8 text-2xl font-semibold text-neutral-900">Data Security</h2>
                <p class="text-neutral-700">
                    We implement appropriate security measures to protect your information. Images submitted for
                    verification are processed in real-time and are not stored on our servers after analysis is
                    complete.
                </p>

                <h2 class="mt-8 text-2xl font-semibold text-neutral-900">Contact Us</h2>
                <p class="text-neutral-700">
                    If you have questions about this Privacy Policy, please
                    <a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-500">contact us</a>.
                </p>
            </div>
        </div>
    </section>
@endsection
