@use(Illuminate\Support\Facades\Vite)

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VKS70BYBWN"></script>
<script nonce="{{ Vite::cspNonce() }}">
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-VKS70BYBWN');
</script>
