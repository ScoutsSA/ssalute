<?php

namespace Tests\Unit\Services;

use App\Services\LegacyHtmlService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LegacyHtmlServiceTest extends TestCase
{
    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function repairableValues(): array
    {
        return [
            'three layers, already rendered correctly' => ['Fires &amp;amp;amp; Cooking', 'Fires & Cooking'],
            'four layers, showing residue' => ['Fires &amp;amp;amp;amp; Cooking', 'Fires & Cooking'],
            'sixteen layers' => ['C/o Diaz ' . '&' . str_repeat('amp;', 16) . ' Plattekloof Road', 'C/o Diaz & Plattekloof Road'],
            'an apostrophe' => ['Bushman&amp;amp;amp;amp;amp;amp;#039;s Thong', "Bushman's Thong"],
            'a non breaking space' => ['Sun&amp;amp;amp;amp;nbsp;heat', "Sun\u{00A0}heat"],
        ];
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function unsafeValues(): array
    {
        return [
            'tag-like text the legacy render strips' => ['I &amp;amp;amp;amp;lt;3 camp'],
            'a double quote the legacy render drops' => ['26&deg;01&#039;16.3&amp;amp;amp;amp;quot;S'],
            'a backslash the legacy render strips again' => ['Stephen \\\\Munro &amp;amp;amp;amp; Wolf'],
        ];
    }

    #[Test]
    #[DataProvider('repairableValues')]
    public function it_repairs_values_whose_only_display_difference_is_leftover_encoding(string $stored, string $expected): void
    {
        $this->assertSame($expected, LegacyHtmlService::repair($stored));
    }

    #[Test]
    #[DataProvider('unsafeValues')]
    public function it_keeps_values_whose_display_would_change_beyond_the_residue(string $stored): void
    {
        $this->assertSame($stored, LegacyHtmlService::repair($stored));
    }

    #[Test]
    public function it_returns_null_and_empty_values_as_they_are(): void
    {
        $this->assertNull(LegacyHtmlService::repair(null));
        $this->assertSame('', LegacyHtmlService::repair(''));
    }

    #[Test]
    public function it_is_idempotent(): void
    {
        $repaired = LegacyHtmlService::repair('Fires &amp;amp;amp;amp; Cooking');

        $this->assertSame($repaired, LegacyHtmlService::repair($repaired));
    }

    #[Test]
    public function decoding_now_reaches_the_deepest_live_layering(): void
    {
        $this->assertSame('Diaz & Plattekloof', LegacyHtmlService::decode('Diaz &' . str_repeat('amp;', 16) . ' Plattekloof'));
    }
}
