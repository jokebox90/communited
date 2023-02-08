<?php

declare(strict_types=1);

use App\Collection\ArticleCollection;
use PHPUnit\Framework\TestCase;

final class ArticleCollectionTest extends TestCase
{
    public function testNombreArticle(): void
    {
        $nbArticle = 5;
        $articles = new ArticleCollection();
        $results = $articles->getAll($nbArticle);

        $this->assertSame($nbArticle, count($results));
    }

    public function testGrandNombreArticle(): void
    {
        $nbArticle = 5000;
        $articles = new ArticleCollection();
        $results = $articles->getAll($nbArticle);

        $this->assertSame($nbArticle, count($results));
    }

    public function testStructureDeChaqueArticle(): void
    {
        $nbArticle = 5000;
        $articles = new ArticleCollection();
        $results = $articles->getAll($nbArticle);

        for ($i = 0; $i < count($results); $i++) {
            $article = $results[$i];
            $this->assertIsArray($article);
            $this->assertArrayHasKey("title", $article);
            $this->assertArrayHasKey("description", $article);
            $this->assertArrayHasKey("available", $article);

            $this->assertIsArray($article["prices"]);
            for ($j = 0; $j < count($article["prices"]); $j++) {
                $price = $article["prices"][$j];
                $this->assertArrayHasKey("amount", $price);
                $this->assertArrayHasKey("duration", $price);
                $this->assertArrayHasKey("frequency", $price);
            }
        }
    }
}
