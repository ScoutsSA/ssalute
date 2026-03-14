<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
