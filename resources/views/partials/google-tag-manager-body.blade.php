@if ($gtmId = config('services.google_tag_manager.id'))
    {{-- Google Tag Manager (noscript) --}}
    {{-- sheath-disable a11y-require-frame-title -- hidden 0x0 GTM noscript beacon, never shown to users --}}
    <noscript
        ><iframe
            src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
            height="0"
            width="0"
            class="hidden invisible"
        ></iframe
    ></noscript>
    {{-- sheath-enable a11y-require-frame-title --}}
    {{-- End Google Tag Manager (noscript) --}}
@endif
