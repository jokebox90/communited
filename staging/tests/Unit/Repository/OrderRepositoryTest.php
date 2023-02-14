<?php

declare(strict_types=1);

namespace Tests\Unit\Repository;

use App\Entity\Order;
use App\Entity\OrderItem;
use PHPUnit\Framework\Attributes\Group;
use Tests\Base\RepositoryTestBase;


final class OrderRepositoryTest extends RepositoryTestBase
{
    const AVAILABLE_STATUS = Order::AVAILABLE_STATUS;

    #[Group("unit")]
    public function testFindAll()
    {
        $orders = $this->entityManager
            ->getRepository(Order::class)
            ->findAll();

        for ($i = 0; $i < count($orders); $i++) {
            $this->assertOrderEntity($orders[$i]);
        }
    }

    protected function assertOrderEntity($order): void
    {
        $this->assertUniqueId($order->getUniqueId());
        $this->assertUniqueId($order->getCustomerId());
        $this->assertUniqueId($order->getAddressId());
        $this->assertIsStringWithMaxLength(30, $order->getReference());
        $this->assertEmailAddress($order->getEmailAddress());
        $this->assertIsStringWithMaxLength(500, $order->getReference());

        $this->assertCollectionContainsInstancesOf($order->getOrderItems(), OrderItem::class);
        $this->assertStatus($order->getStatus());
    }
}
