<?php

declare(strict_types=1);

require_once('../staging/fake.php');

use PHPUnit\Framework\TestCase;

final class FakeDataTest extends TestCase
{
    public function testFakeData(): void
    {
        $nombreArticle = 5;
        $result = fake_data($nombreArticle);

        $this->assertSame($nombreArticle, count($result));
    }
}
