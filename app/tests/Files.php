<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class Files extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Files::class,
            Files::fromString('user@example.com')
        );
    }
}