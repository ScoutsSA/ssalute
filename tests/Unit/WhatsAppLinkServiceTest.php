<?php

namespace Tests\Unit;

use App\Services\WhatsAppLinkService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class WhatsAppLinkServiceTest extends TestCase
{
    /** @return array<string, array{?string, ?string}> */
    public static function cellNumberProvider(): array
    {
        return [
            'local number' => ['0821234567', 'https://wa.me/27821234567'],
            'local number with spaces' => ['082 123 4567', 'https://wa.me/27821234567'],
            'international number' => ['27821234567', 'https://wa.me/27821234567'],
            'international with plus and dashes' => ['+27-82-123-4567', 'https://wa.me/27821234567'],
            'too short' => ['082123', null],
            'foreign number' => ['+44 7700 900123', null],
            'empty' => ['', null],
            'null' => [null, null],
        ];
    }

    #[Test]
    #[DataProvider('cellNumberProvider')]
    public function it_builds_a_wa_me_link_for_south_african_numbers_only(?string $cellNr, ?string $expected): void
    {
        $this->assertSame($expected, WhatsAppLinkService::for($cellNr));
    }
}
