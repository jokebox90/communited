<?php

declare(strict_types=1);

// staging/src/DataFixtures/CustomerFixtures.php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Address;
use App\Entity\CustomerPrice;
use App\Repository\CustomerRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Ramsey\Uuid\Uuid;

final class CustomerFixtures extends Fixture
{
    const COUNTER = 50;
    const POSTAL_ADDRESS_COUNTER = 2;
    private EntityManagerInterface|null $em = null;
    private CustomerRepository|null $customerRepository = null;
    private Faker\Generator|null $faker = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->customerRepository = $doctrine->getRepository(Customer::class);
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNTER; $i++) {
            $customerId = (Uuid::uuid4())->toString();

            $Address = [];
            for ($j = 0; $j < self::POSTAL_ADDRESS_COUNTER; $j++) {
                $address[] = [
                    "uniqueId"        => (Uuid::uuid4())->toString(),
                    "customerId"      => $customerId,
                    "street"          => $this->faker->streetAddress(),
                    "postalCode"      => $this->faker->postcode(),
                    "locality"        => $this->faker->city(),
                    "country"         => "France",
                    "residence"       => $this->faker->sentence(3),
                    "floor"           => $this->faker->randomNumber(1),
                    "entryCode"       => sprintf(
                        "%d%d%s%d%d",
                        $this->faker->randomNumber(1),
                        $this->faker->randomNumber(1),
                        $this->faker->randomElement(["A", "B"]),
                        $this->faker->randomNumber(1),
                        $this->faker->randomNumber(1),
                    ),
                    "intercom"        => $this->faker->randomNumber(3),
                    "additionalNotes" => implode(" ", $this->faker->sentences(5)),
                    "status"          => $this->faker->randomElement(Address::AVAILABLE_STATUS),
                ];
            }

            $customerArray = [
                "uniqueId"     => $customerId,
                "firstName"    => $this->faker->firstName(),
                "lastName"     => $this->faker->lastName(),
                "grade"        => $this->faker->randomElement(Customer::AVAILABLE_GRADES),
                "phoneNumber"  => $this->faker->phoneNumber(),
                "emailAddress" => $this->faker->email(),
                "birthDate"    => $this->faker->dateTimeBetween('-99 year', '-13 years')->format("Y-m-d"),
                "status"       => $this->faker->randomElement(Customer::AVAILABLE_STATUS),
                "address"      => $address,
            ];

            $newCustomer = new Customer();
            $newCustomer->exchangeArray($customerArray);
            $this->customerRepository->save($newCustomer);
        }

        $this->em->flush();
    }

    public static function getGroups(): array
    {
        return ["customer"];
    }
}
