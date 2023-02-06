<?php

declare(strict_types=1);

require_once('../staging/fake.php');

use PHPUnit\Framework\TestCase;

final class FakeDataTest extends TestCase
{
    public function testNombreArticle(): void
    {
        $nombreArticle = 5;
        $collection = getArticleCollection($nombreArticle);

        $this->assertSame($nombreArticle, count($collection));
    }

    public function testGrandNombreArticle(): void
    {
        $nombreArticle = 5000;
        $collection = getArticleCollection($nombreArticle);

        $this->assertSame($nombreArticle, count($collection));
    }

    public function testStructureDeChaqueArticle(): void
    {
        $nombreArticle = 5000;
        $collection = getArticleCollection($nombreArticle);

        for ($i = 0; $i < count($collection); $i++) {
            $article = $collection[$i];
            $this->assertIsArray($article);
            $this->assertArrayHasKey("title", $article);
            $this->assertArrayHasKey("description", $article);
            $this->assertArrayHasKey("price", $article);
            $this->assertArrayHasKey("duration", $article);
            $this->assertArrayHasKey("frequency", $article);
        }
    }
}
