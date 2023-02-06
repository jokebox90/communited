<?php

declare(strict_types=1);

require_once('../staging/fake.php');

use PHPUnit\Framework\TestCase;

final class FakeDataTest extends TestCase
{
    public function testNombreArticle(): void
    {
        $nombreArticle = 5;
        $result = fake_data($nombreArticle);

        $this->assertSame($nombreArticle, count($result));
    }

    public function testGrandNombreArticle(): void
    {
        $nombreArticle = 5000;
        $result = fake_data($nombreArticle);

        $this->assertSame($nombreArticle, count($result));
    }

    public function testStructureDeChaqueArticle(): void
    {
        $nombreArticle = 5000;
        $result = fake_data($nombreArticle);

        $this->assertSame($nombreArticle, count($result));

        for ($i = 0; $i < $nombreArticle; $i++) {
            $article = $result[$i];
            $this->assertArrayHasKey("title", $article);
            $this->assertArrayHasKey("description", $article);
            $this->assertArrayHasKey("price", $article);
            $this->assertArrayHasKey("duration", $article);
        }
    }
}
