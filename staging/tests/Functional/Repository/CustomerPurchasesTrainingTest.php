<?php

declare(strict_types=1);

namespace Tests\Functional\Repository;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Customer;
use App\Entity\Sold;
use App\Service\OrderReferenceGenerator;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Group;
use Ramsey\Uuid\Uuid;
use Tests\Base\RepositoryTestBase;


#[Group("functional")]
final class CustomerPurchasesTrainingTest extends RepositoryTestBase
{
    public function testTheCustomerAddsAnItemToTheCart(): array
    {
        $training = $this->entityManager
            ->getRepository(Item::class)
            ->findOneBy(["title" => "Data Science"]);

        $this->assertNotNull($training);
        $this->assertInstanceOf(Item::class, $training);

        $sold = new Sold();
        $sold->setUniqueId($this->uuid->create());
        $sold->setPrice($training->getPrices()->first());
        $sold->setAdditionalNotes("En présentiel.");

        $orderId = $this->uuid->create();
        $order = new Order();
        $order->setUniqueId($orderId);
        $order->setReference(OrderReferenceGenerator::create());
        $order->setAdditionalNotes("N/A");

        $now = new DateTime();
        $order->setCreatedAt($now);
        $order->setModifiedAt($now);
        $order->setStatus(Order::STATUS_OPEN);

        $order->addItemToSold($sold);

        $this->entityManager
            ->getRepository(Order::class)
            ->save($order, true);

        return [
            "orderId" => $orderId,
            "itemId" => $training->getUniqueId(),
        ];
    }

    #[Depends("testTheCustomerAddsAnItemToTheCart")]
    public function testEnsureTheTrainingPriceMatchTheOrderPrice(array $stack): array
    {
        $training = $this->entityManager
            ->getRepository(Item::class)
            ->find($stack["itemId"]);

        $orderResult = $this->entityManager
            ->getRepository(Order::class)
            ->find($stack["orderId"]);

        $this->assertEquals(
            $orderResult->getSoldItems()->first()->getPrice(),
            $training->getPrices()->first()
        );

        return $stack;
    }

    #[Depends("testEnsureTheTrainingPriceMatchTheOrderPrice")]
    public function testTheCustomerConfirmsHisPersonalInformation(array $stack): array
    {
        $customerArray = [
            "firstName"     => "Sophie",
            "lastName"      => "Lozofi",
            "grade"         => Customer::GRADE_LEGEND,
            "phoneNumber"   => $this->faker->phoneNumber(),
            "emailAddress"  => "sophie.lozofi@once.fr",
            "birthDate"     => $this->faker->dateTimeBetween('-99 year', '-13 years')->format("Y-m-d"),
            "status"        => Customer::STATUS_ACTIVE,
            "address" => [
                [
                    "uniqueId"        => $this->uuid->create(),
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
                    "status"          => Customer::STATUS_ACTIVE,
                ]
            ],
        ];

        $customer = new Customer();
        $customer->exchangeArray($customerArray);

        $this->assertUniqueId($customer->getUniqueId());

        $this->entityManager
            ->getRepository(Customer::class)
            ->save($customer, true);

        $stack["customerId"] = $customer->getUniqueId();
        return $stack;
    }

    #[Depends("testTheCustomerConfirmsHisPersonalInformation")]
    public function testTheOrderIsUpdatedWithCustomerPersonalInformation(array $stack): array
    {
        $order = $this->entityManager
            ->getRepository(Order::class)
            ->find($stack["orderId"]);

        $this->assertNotNull($order);

        $customer = $this->entityManager
            ->getRepository(Customer::class)
            ->find($stack["customerId"]);

        $this->assertNotNull($customer);

        $order->setCustomer($customer);
        $order->setAddress($customer->getAddress()->last());
        $order->setEmailAddress($customer->getEmailAddress());

        $order = $this->entityManager
            ->getRepository(Order::class)
            ->save($order, true);

        return $stack;
    }

    #[Depends("testTheOrderIsUpdatedWithCustomerPersonalInformation")]
    public function testOrderCreatedLessThan5minAgo(array $stack): void
    {
        $order = $this->entityManager
            ->getRepository(Order::class)
            ->find($stack["orderId"]);

        $yesterday = new DateTime("yesterday");
        $date = $order->getCreatedAt();
        $interval = $date->diff($yesterday, true);
        $this->assertLessThanOrEqual(5, $interval->m);
    }
}
