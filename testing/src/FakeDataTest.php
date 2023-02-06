<?php

declare(strict_types=1);

require_once('../staging/fake.php');

use PHPUnit\Framework\TestCase;

final class FakeDataTest extends TestCase
{
    public function testFakeData(): void
    {
        $nombreArtcile = 5;
        $result = fake_data($nombreArtcile);

        $this->assertSame($nombreArtcile, count($result));
    }
}
