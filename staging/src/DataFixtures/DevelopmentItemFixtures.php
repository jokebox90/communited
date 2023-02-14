<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Service\UniqueIdGenerator;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DevelopmentItemFixtures extends Fixture implements FixtureGroupInterface
{
    private UniqueIdGenerator|null $uuid = null;

    public function __construct(UniqueIdGenerator $uuid)
    {
        $this->uuid = $uuid;
    }

    public function load(ObjectManager $manager): void
    {
        $uniqueId = $this->uuid->create();
        $array = [
            "uniqueId"    => $uniqueId,
            "title"       => "Développement web et mobile",
            "description" => "Formation en développement web",
            "available"   => 60,
            "tags"        => ["formation", "développement", "web", "mobile"],
            "status"      => "actif",
            "prices"      => [
                [
                    "uniqueId"    => $this->uuid->create(),
                    "itemId"   => $uniqueId,
                    "amount"      => 1600,
                    "description" => "Paiement par mois",
                    "duration"    => 12,
                    "frequency"   => "mensuel",
                    "status"      => "actif",
                ],
                [
                    "uniqueId"    => $this->uuid->create(),
                    "itemId"   => $uniqueId,
                    "amount"      => 1600,
                    "description" => "Paiement par trimestre",
                    "duration"    => 4,
                    "frequency"   => "trimestriel",
                    "status"      => "actif",
                ],
                [
                    "uniqueId"    => $this->uuid->create(),
                    "itemId"   => $uniqueId,
                    "amount"      => 1600,
                    "description" => "Paiement par année",
                    "duration"    => 1,
                    "frequency"   => "trimestriel",
                    "status"      => "annuel",
                ],
            ],
        ];

        $newItem = new Item();
        $newItem->exchangeArray($array);

        $now = new DateTime();
        $newItem->setCreatedAt($now);
        $newItem->setModifiedAt($now);

        $manager->persist($newItem);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            "test",
            "items",
        ];
    }
}
