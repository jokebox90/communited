<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MerchantFixtures::class,
            DataScienceItemFixtures::class,
            DevelopmentItemFixtures::class,
            ProjectManagementItemFixtures::class,
            UxUiDesignItemFixtures::class,
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
