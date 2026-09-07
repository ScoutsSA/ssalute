<?php

namespace Tests\Unit\Models;

use App\Models\AmsLicenceType;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AmsLicenceTypeTest extends TestCase
{
    #[Test]
    public function expiry_date_is_the_issue_date_plus_the_validity_in_years(): void
    {
        $type = new AmsLicenceType(['expiryYears' => 3]);

        $this->assertSame('2028-01-15', $type->expiryDateFor('2025-01-15')->toDateString());
        $this->assertSame('2028-01-15', $type->expiryDateFor(CarbonImmutable::parse('2025-01-15 14:30'))->toDateString());
    }

    #[Test]
    public function expiry_date_is_not_shortened_by_a_day_or_rounded_to_month_end(): void
    {
        $type = new AmsLicenceType(['expiryYears' => 5]);

        $this->assertSame('2031-03-14', $type->expiryDateFor('2026-03-14')->toDateString());
    }

    #[Test]
    public function a_leap_day_issue_date_rolls_over_to_the_first_of_march(): void
    {
        $type = new AmsLicenceType(['expiryYears' => 5]);

        $this->assertSame('2029-03-01', $type->expiryDateFor('2024-02-29')->toDateString());
    }
}
