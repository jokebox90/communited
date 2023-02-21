<?php

declare(strict_types=1);

// src/DataFixtures/MerchantFixtures.php

namespace App\DataFixtures;

use App\Entity\Merchant;
use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\MerchantPrice;
use App\Repository\MerchantRepository;
use App\Service\UniqueIdGenerator;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Ramsey\Uuid\Uuid;

final class MerchantFixtures extends Fixture implements FixtureGroupInterface
{
    const COUNTER = 50;
    const POSTAL_ADDRESS_COUNTER = 2;
    private EntityManagerInterface|null $em = null;
    private MerchantRepository|null $merchantRepository = null;
    private UniqueIdGenerator|null $uuid = null;
    private Faker\Generator|null $faker = null;

    public function __construct(ManagerRegistry $doctrine, UniqueIdGenerator $uuid)
    {
        $this->em = $doctrine->getManager();
        $this->merchantRepository = $doctrine->getRepository(Merchant::class);
        $this->uuid = $uuid;
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $now = new DateTime();
        $contactArray = [
            "uniqueId"        => $this->uuid->create(),
            "status"          => "actif",
            "createdAt"       => $now->format(DateTime::ATOM),
            "modifiedAt"      => $now->format(DateTime::ATOM),
            "contactName"     => "Jean Veuzencor",
            "role"            => "Conseiller pédagogique",
            "emailAddress"    => "jean.veuzencor@twice.fr",
            "phoneNumber"     => $this->faker->phoneNumber(),
            "street"          => $this->faker->streetAddress(),
            "postalCode"      => $this->faker->postcode(),
            "locality"        => $this->faker->city(),
            "country"         => "France",
            "siret"           => sprintf(
                "%d%d%d000%d",
                random_int(100, 999),
                random_int(100, 999),
                random_int(100, 999),
                random_int(10, 99)
            ),
            "vat"           => sprintf(
                "FR%d%d%d",
                random_int(100, 999),
                random_int(100, 999),
                random_int(100, 999)
            ),
            "additionalNotes" => implode(" ", $this->faker->sentences(5)),
        ];

        $newContact = new Contact();
        $newContact->exchangeArray($contactArray);

        $merchantArray = [
            "uniqueId"         => $this->uuid->create(),
            "status"           => "actif",
            "createdAt"        => $now->format(DateTime::ATOM),
            "modifiedAt"       => $now->format(DateTime::ATOM),
            "companyName"      => "BornToCode",
            "activity"         => sprintf(
                "%d%d%s",
                random_int(10, 99),
                random_int(10, 99),
                ["A", "B", "C"][random_int(0, 2)]
            ),
            "phoneNumber"      => $this->faker->phoneNumber(),
            "emailAddress"     => $this->faker->email(),
            "street"           => $this->faker->streetAddress(),
            "postalCode"       => $this->faker->postcode(),
            "locality"         => $this->faker->city(),
            "country"          => "France",
            "registrationDate" => $this->faker->dateTimeBetween('-20 year', '-2 years')->format("Y-m-d"),
            "website"          => "www.twice.fr",
            "status"           => "actif",
        ];

        $newMerchant = new Merchant();
        $newMerchant->exchangeArray($merchantArray);
        $newMerchant->addContact($newContact);
        $this->merchantRepository->save($newMerchant);

        $this->em->flush();
    }

    public static function getGroups(): array
    {
        return [
            "test",
            "merchant"
        ];
    }
}
