<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\Merchant;
use App\Service\UniqueIdGenerator;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DataScienceItemFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
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
            "title"       => "Data Science",
            "description" => "Formation en data science",
            "available"   => 60,
            "tags"        => ["formation", "data", "deeplearning", "machinelearning"],
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

        $merchantRepository = $manager->getRepository(Merchant::class);
        $school = $merchantRepository->findOneBy(["companyName" => "BornToCode"]);
        $coach = $school->getContacts()->first();
        foreach($newItem->getPrices() as $price) {
            $price->setContact($coach);
        }

        $manager->persist($newItem);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MerchantFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return [
            "test",
            "items",
        ];
    }
}
