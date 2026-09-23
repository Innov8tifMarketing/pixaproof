<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class HomepageComponentsTest extends TestCase
{
    public function test_check_list_renders_one_item_per_entry(): void
    {
        $html = Blade::render('<x-check-list :items="$items" />', ['items' => ['First', 'Second', 'Third']]);

        $this->assertSame(3, substr_count($html, '<li class="flex items-start gap-3">'));
        $this->assertStringContainsString('space-y-3', $html);
        $this->assertStringContainsString('First', $html);
        $this->assertStringContainsString('Third', $html);
    }

    public function test_check_list_compact_tightens_spacing(): void
    {
        $html = Blade::render('<x-check-list :items="$items" compact />', ['items' => ['Only']]);

        $this->assertSame(1, substr_count($html, '<li class="flex items-start gap-2">'));
        $this->assertStringContainsString('space-y-2', $html);
        $this->assertStringNotContainsString('gap-3', $html);
    }

    public function test_check_list_escapes_items(): void
    {
        $html = Blade::render('<x-check-list :items="$items" />', ['items' => ['<b>bold</b>']]);

        $this->assertStringContainsString('&lt;b&gt;bold&lt;/b&gt;', $html);
        $this->assertStringNotContainsString('<b>bold</b>', $html);
    }

    public function test_section_renders_anchor_reveal_and_header(): void
    {
        $html = Blade::render('<x-section id="faq" eyebrow="FAQ" title="Questions" description="Answers here" class="bg-white">Body</x-section>');

        $this->assertStringContainsString('id="faq"', $html);
        $this->assertStringContainsString('x-data="{ visible: false }"', $html);
        $this->assertStringContainsString('x-intersect.once="visible = true"', $html);
        $this->assertStringContainsString('class="py-20 lg:py-28 bg-white"', $html);
        $this->assertMatchesRegularExpression('/<p class="[^"]*uppercase[^"]*">FAQ<\/p>/', $html);
        $this->assertMatchesRegularExpression('/<h2 class="[^"]*">Questions<\/h2>/', $html);
        $this->assertMatchesRegularExpression('/<p class="mx-auto max-w-3xl [^"]*">Answers here<\/p>/', $html);
        $this->assertStringContainsString('max-w-7xl', $html);
        $this->assertStringContainsString('Body', $html);
    }

    public function test_section_omits_header_when_no_header_props(): void
    {
        $html = Blade::render('<x-section padding="py-16" width="max-w-4xl">Body</x-section>');

        $this->assertStringNotContainsString('<h2', $html);
        $this->assertStringNotContainsString('text-center', $html);
        $this->assertStringNotContainsString('id=', $html);
        $this->assertStringContainsString('class="py-16"', $html);
        $this->assertStringContainsString('max-w-4xl', $html);
    }

    public function test_section_accepts_custom_intersect_and_background_slot(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-section intersect="visible = true; Motion.staggerFadeIn($el.querySelectorAll('[data-card]'))">
                <x-slot:background><div class="dots"></div></x-slot:background>
                Body
            </x-section>
            BLADE);

        $this->assertStringContainsString('[data-card]', html_entity_decode($html));
        $this->assertStringContainsString('<div class="dots"></div>', $html);
        $this->assertLessThan(strpos($html, 'Body'), strpos($html, 'class="dots"'));
    }

    public function test_icon_card_default_inline_layout(): void
    {
        $html = Blade::render('<x-icon-card data-layer-card icon="camera" title="Capture Integrity">Body copy</x-icon-card>');

        $this->assertStringContainsString('data-layer-card', $html);
        $this->assertStringContainsString('border-neutral-200', $html);
        $this->assertStringContainsString('hover:-translate-y-1', $html);
        $this->assertStringContainsString('h-10 w-10', $html);
        $this->assertStringContainsString('<svg', $html);
        $this->assertStringContainsString('<h3 class="font-heading font-semibold text-neutral-900">Capture Integrity</h3>', $html);
        $this->assertStringContainsString('<p class="text-neutral-600">', $html);
        $this->assertStringContainsString('Body copy', $html);
    }

    public function test_icon_card_inverted_variant(): void
    {
        $html = Blade::render('<x-icon-card variant="inverted" icon="bolt" title="Fast" class="mt-6">Body</x-icon-card>');

        $this->assertStringContainsString('bg-primary-600', $html);
        $this->assertStringContainsString('mt-6', $html);
        $this->assertStringContainsString('bg-white/20', $html);
        $this->assertStringContainsString('<p class="text-primary-100">', $html);
        $this->assertStringNotContainsString('border-neutral-200', $html);
    }

    public function test_icon_card_stacked_layout_with_large_icon(): void
    {
        $html = Blade::render('<x-icon-card layout="stacked" iconSize="lg" icon="shield-check" title="ISO">Body</x-icon-card>');

        $this->assertStringContainsString('text-center', $html);
        $this->assertStringContainsString('mx-auto mb-4', $html);
        $this->assertStringContainsString('h-12 w-12', $html);
        $this->assertStringContainsString('h-6 w-6', $html);
        $this->assertStringContainsString('<p class="text-sm text-neutral-600">', $html);
    }

    public function test_stat_with_text_uses_x_text(): void
    {
        $html = Blade::render('<x-stat text="<500ms" label="Verification Speed" />');

        $this->assertStringContainsString('x-text="visible ? \'\u003C500ms\' : \'0\'"', $html);
        $this->assertStringNotContainsString('animateCounter', $html);
        $this->assertStringContainsString('Verification Speed', $html);
    }

    public function test_stat_with_value_animates_counter(): void
    {
        $html = Blade::render('<x-stat value="10" suffix="M+" label="Verifications" />');

        $this->assertStringContainsString("Motion.animateCounter(\$el, 10, 'M+')", $html);
        $this->assertStringNotContainsString('x-text', $html);
    }

    public function test_stat_suffix_defaults_to_empty(): void
    {
        $html = Blade::render('<x-stat value="3" label="Patents" />');

        $this->assertStringContainsString("Motion.animateCounter(\$el, 3, '')", $html);
    }
}
