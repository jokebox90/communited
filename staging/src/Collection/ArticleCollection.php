<?php

namespace App\Collection;

final class ArticleCollection
{
    public static function getArticleCollection($limit)
    {
        $fake = \Faker\Factory::create('fr_FR');

        $collection = array();

        for ($i = 0; $i < $limit; $i++) {
            $unArticleFakeIci = [
                "title" => $fake->sentence(5),
                "description" => $fake->paragraph(),
                "price" => $fake->randomElement([30, 60, 90, 120, 150]),
                "duration" => $fake->numberBetween(1, 5),
                "available" => $fake->numberBetween(10, 50),
                "frequency" => $fake->randomElement(["semaine", "mois", "trimestre", "semestre", "annuel"])
            ];

            array_push($collection, $unArticleFakeIci);
        }

        return $collection;
    }
}
