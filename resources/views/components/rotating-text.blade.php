@props([
    'words' => [],
    'interval' => 3000,
    'class' => '',
])

<span
    x-data="{
        words: {{ Js::from($words) }},
        currentIndex: 0,
        interval: {{ $interval }},
        isAnimating: false,

        init() {
            this.startRotation();
        },

        startRotation() {
            setInterval(() => {
                if (! this.isAnimating) {
                    this.swapWord();
                }
            }, this.interval);
        },

        async swapWord() {
            this.isAnimating = true;

            await window.Motion.textSwap(this.$refs.word, {
                onMidpoint: () => {
                    this.currentIndex = (this.currentIndex + 1) % this.words.length;
                }
            });

            this.isAnimating = false;
        }
    }"
    class="inline-block"
    {{ $attributes->except('class') }}
>
    <span x-ref="word" x-text="words[currentIndex]" class="{{ $class }}"></span>
</span>
