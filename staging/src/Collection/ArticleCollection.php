<?php

namespace App\Collection;

use Faker;


final class ArticleCollection
{

    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function getById(string $articleId)
    {
        return [
            "unique_id"   => $articleId,
            "title"       => $this->faker->sentence(5),
            "description" => $this->faker->paragraph(),
            "available"   => $this->faker->numberBetween(10, 50),
            "prices"      => [
                [
                    "amount"    => $this->faker->randomElement([30, 60, 90, 120, 150]),
                    "duration"  => $this->faker->numberBetween(1, 3),
                    "frequency" => $this->faker->randomElement([
                        "semaine",
                        "mois",
                        "trimestre",
                        "annuel"
                    ]),
                ],
                [
                    "amount"    => $this->faker->randomElement([30, 60, 90, 120, 150]),
                    "duration"  => $this->faker->numberBetween(1, 3),
                    "frequency" => $this->faker->randomElement([
                        "semaine",
                        "mois",
                        "trimestre",
                        "annuel"
                    ]),
                ],
                [
                    "amount"    => $this->faker->randomElement([30, 60, 90, 120, 150]),
                    "duration"  => $this->faker->numberBetween(1, 3),
                    "frequency" => $this->faker->randomElement([
                        "semaine",
                        "mois",
                        "trimestre",
                        "annuel"
                    ]),
                ],
            ],
            "tags"        => [
                $this->faker->randomElement(["un", "deux", "trois", "quatre"]),
                $this->faker->randomElement(["cinq", "six", "sept", "huit"]),
                $this->faker->randomElement(["neuf", "dix", "onze", "douze"]),
                $this->faker->randomElement(["treize", "quatorze", "quinze", "seize"]),
            ],
        ];
    }

    public function getAll($limit)
    {
        $articleList = [];

        for ($i = 0; $i < $limit; $i++) {
            $articleList[] = $this->getById($this->faker->uuid());
        }

        return $articleList;
    }
}
