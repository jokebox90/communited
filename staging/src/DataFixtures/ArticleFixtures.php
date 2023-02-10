<?php

declare(strict_types=1);

// staging/src/DataFixtures/ArticleFixtures.php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticlePrice;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Ramsey\Uuid\Uuid;

final class ArticleFixtures extends Fixture
{
    const COUNTER = 50;
    private EntityManagerInterface|null $em = null;
    private ArticleRepository|null $articleRepository = null;
    private Faker\Generator|null $faker = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->articleRepository = $doctrine->getRepository(Article::class);
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNTER; $i++) {
            $articleId = (Uuid::uuid4())->toString();

            $prices = [];
            for ($j = 0; $j < 5; $j++) {
                $prices[] = [
                    "uniqueId" => (Uuid::uuid4())->toString(),
                    "articleId" => $articleId,
                    "amount" => $this->faker->randomElement([60, 90, 120, 150]),
                    "description" => $this->faker->sentence(12),
                    "duration" => $this->faker->randomElement([1, 2, 3]),
                    "frequency" => $this->faker->randomElement([
                        "journalier",
                        "hebdomadaire",
                        "mensuel",
                        "trimestriel",
                        "annuel"
                    ]),
                    "status"      => $this->faker->randomElement([
                        "actif",
                        "inactif"
                    ]),
                ];
            }

            $articleArray = [
                "uniqueId"    => $articleId,
                "title"       => $this->faker->sentence(12),
                "description" => implode(" ", $this->faker->sentences(12)),
                "available"   => $this->faker->numberBetween(10, 50),
                "tags"        => [
                    $this->faker->randomElement(["un", "deux", "trois", "quatre"]),
                    $this->faker->randomElement(["cinq", "six", "sept", "huit"]),
                    $this->faker->randomElement(["neuf", "dix", "onze", "douze"]),
                    $this->faker->randomElement(["treize", "quatorze", "quinze", "seize"]),
                ],
                "status"      => $this->faker->randomElement(Article::AVAILABLE_STATUS),
                "prices"      => $prices,
            ];

            $newArticle = new Article();
            $newArticle->exchangeArray($articleArray);
            $this->articleRepository->save($newArticle);
        }

        $this->em->flush();
    }

    public static function getGroups(): array
    {
        return ["article"];
    }
}
