@if ($gtmId = config('services.google_tag_manager.id'))
    {{-- Google Tag Manager (noscript) --}}
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
        height="0" width="0" class="hidden invisible"></iframe></noscript>
    {{-- End Google Tag Manager (noscript) --}}
@endif
