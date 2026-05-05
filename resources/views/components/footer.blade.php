<footer class="border-t border-neutral-200 bg-neutral-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <!-- Main Footer Grid -->
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Brand Column -->
            <div class="sm:col-span-2 lg:col-span-1">
                <img src="{{ asset('images/pixaproof-wordmark.svg') }}" alt="PixaProof" class="h-8 w-auto shrink-0">
                <p class="mt-4 text-sm text-neutral-600">
                    Enterprise-grade image authenticity verification. Detect tampering, validate metadata, and establish chain of custody.
                </p>
                <p class="mt-4 text-sm text-neutral-500">
                    A product of <a href="https://innov8tif.com" target="_blank" rel="noopener noreferrer" class="text-neutral-600 transition hover:text-primary-600">Innov8tif</a>
                </p>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-500">Navigation</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="/#solutions" class="text-sm text-neutral-600 transition hover:text-primary-600">Solutions</a></li>
                    <li><a href="/#technology" class="text-sm text-neutral-600 transition hover:text-primary-600">Technology</a></li>
                    <li><a href="/#about" class="text-sm text-neutral-600 transition hover:text-primary-600">About</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-500">Contact</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('contact') }}" class="text-sm text-neutral-600 transition hover:text-primary-600">Request Demo</a></li>
                    <li><a href="mailto:sales@innov8tif.com" class="text-sm text-neutral-600 transition hover:text-primary-600">sales@innov8tif.com</a></li>
                    <li><a href="https://innov8tif.com" target="_blank" rel="noopener noreferrer" class="text-sm text-neutral-600 transition hover:text-primary-600">innov8tif.com</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-500">Legal</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('privacy') }}" class="text-sm text-neutral-600 transition hover:text-primary-600">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 border-t border-neutral-200 pt-8 flex flex-col items-center justify-between gap-4 md:flex-row">
            <div class="text-sm text-neutral-500">
                &copy; {{ date('Y') }} Innov8tif Solutions Pte. Ltd. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a href="{{ route('privacy') }}" class="text-sm text-neutral-500 transition hover:text-primary-600">
                    Privacy
                </a>
                <a href="{{ route('contact') }}" class="text-sm text-neutral-500 transition hover:text-primary-600">
                    Contact
                </a>
            </div>
        </div>
    </div>
</footer>
