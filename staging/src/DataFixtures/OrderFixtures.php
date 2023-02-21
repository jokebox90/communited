<?php

declare(strict_types=1);

// src/DataFixtures/OrderFixtures.php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Sold;
use App\Entity\OrderPrice;
use App\Entity\Customer;
use App\Repository\ItemRepository;
use App\Repository\OrderRepository;
use App\Repository\CustomerRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Ramsey\Uuid\Uuid;

final class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    const COUNTER = 100;
    private EntityManagerInterface|null $em = null;
    private ItemRepository|null $itemRepository = null;
    private OrderRepository|null $orderRepository = null;
    private CustomerRepository|null $customerRepository = null;
    private Faker\Generator|null $faker = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->itemRepository = $doctrine->getRepository(Item::class);
        $this->orderRepository = $doctrine->getRepository(Order::class);
        $this->customerRepository = $doctrine->getRepository(Customer::class);
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $items = $this->itemRepository->findAll();
        $customers = $this->customerRepository->findAll();

        for ($i = 0; $i < self::COUNTER; $i++) {
            $orderId = (Uuid::uuid4())->toString();
            $date = $this->faker->dateTimeBetween('-5 years');

            $customer   = $customers[random_int(0, count($customers) - 1)];
            $AddressCollection = $customer->getAddress();
            $Address = $AddressCollection[random_int(0, count($AddressCollection) - 1)];

            $orderArray = [
                "uniqueId"        => $orderId,
                "reference"       => sprintf(
                    "C%s%d",
                    $date->format("Ymd"),
                    $this->faker->randomNumber(5, true)
                ),
                "emailAddress"    => $customer->getEmailAddress(),
                "additionalNotes" => $this->faker->sentence(12),
                "createdAt"       => $date->format(DateTime::ATOM),
                "status"          => $this->faker->randomElement(Order::AVAILABLE_STATUS),
            ];

            $newOrder = new Order();
            $newOrder->exchangeArray($orderArray);
            $newOrder->setCustomer($customer);
            $newOrder->setAddress($Address);

            for ($j = 0; $j < 3; $j++) {
                $item = $items[random_int(0, count($items) - 1)];
                $prices = $item->getPrices();

                $item = new Sold();
                $item->setUniqueId((Uuid::uuid4())->toString());
                $item->setAdditionalNotes($this->faker->sentence(12));
                $item->setPrice($prices[random_int(0, count($prices) - 1)]);

                $newOrder->addSold($item);
            }

            $this->orderRepository->save($newOrder);
        }

        $this->em->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
            ItemFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ["order"];
    }
}
