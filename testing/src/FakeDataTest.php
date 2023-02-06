<?php

declare(strict_types=1);

require_once('../staging/fake.php');

use PHPUnit\Framework\TestCase;

final class FakeDataTest extends TestCase
{
    public function testFakeData(): void
    {
        $result = fake_data(5);

        $this->assertSame(5, count($result));
    }
}
