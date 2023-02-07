<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Collection\ArticleCollection;
use PHPUnit\Framework\TestCase;

final class ArticleCollectionTest extends TestCase
{
    public function testNombreArticle(): void
    {
        $nombreArticle = 5;
        $collection = ArticleCollection::getArticleCollection($nombreArticle);

        $this->assertSame($nombreArticle, count($collection));
    }

    public function testGrandNombreArticle(): void
    {
        $nombreArticle = 5000;
        $collection = ArticleCollection::getArticleCollection($nombreArticle);

        $this->assertSame($nombreArticle, count($collection));
    }

    public function testStructureDeChaqueArticle(): void
    {
        $nombreArticle = 5000;
        $collection = ArticleCollection::getArticleCollection($nombreArticle);

        for ($i = 0; $i < count($collection); $i++) {
            $article = $collection[$i];
            $this->assertIsArray($article);
            $this->assertArrayHasKey("title", $article);
            $this->assertArrayHasKey("description", $article);
            $this->assertArrayHasKey("price", $article);
            $this->assertArrayHasKey("available", $article);
            $this->assertArrayHasKey("duration", $article);
            $this->assertArrayHasKey("frequency", $article);
        }
    }
}
