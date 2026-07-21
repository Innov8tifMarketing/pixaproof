{{--
Cookie Notice (cosmetic)

A courtesy notice only — it does NOT gate Google Tag Manager or set/clear any
cookies. GTM loads unconditionally. Both buttons simply dismiss the notice and
remember the dismissal in localStorage ('pixaproof_cookie_notice') so it does
not reappear on subsequent visits.

Renders only when a GTM container is configured (i.e. production).
--}}
@if (config('services.google_tag_manager.id'))
    <div
        x-cloak
        x-data="{
            open: false,
            init() { this.open = ! localStorage.getItem('pixaproof_cookie_notice'); },
            dismiss() { localStorage.setItem('pixaproof_cookie_notice', '1'); this.open = false; },
        }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        role="region"
        aria-label="Cookie notice"
        class="fixed inset-x-0 bottom-0 z-[60] p-4 sm:p-6"
    >
        <div class="mx-auto max-w-4xl rounded-xl border border-neutral-200 bg-white p-5 shadow-lg sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="text-sm text-neutral-600">
                    <p class="font-semibold text-neutral-900">We value your privacy</p>
                    <p class="mt-1">
                        We use cookies to analyse traffic and improve your experience. See our
                        <a href="{{ route('privacy') }}" class="font-medium text-primary-600 underline hover:text-primary-700">Privacy Policy</a>.
                    </p>
                </div>

                <div class="flex shrink-0 flex-col gap-2 sm:flex-row">
                    <button
                        type="button"
                        @click="dismiss()"
                        class="inline-flex items-center justify-center rounded border border-neutral-300 px-5 py-2.5 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Reject all
                    </button>
                    <button
                        type="button"
                        @click="dismiss()"
                        class="inline-flex items-center justify-center rounded bg-accent-500 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Accept all
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
