<?php

declare(strict_types=1);

namespace Tests\Unit\Repository;

use App\Entity\Item;
use App\Entity\Price;
use Tests\Base\RepositoryTestBase;

#[Group("unit")]
final class ItemRepositoryTest extends RepositoryTestBase
{
    const AVAILABLE_STATUS = Item::AVAILABLE_STATUS;

    public function testFindAll()
    {
        $items = $this->entityManager
            ->getRepository(Item::class)
            ->findAll();

        for ($i = 0; $i < count($items); $i++) {
            $this->assertItemEntity($items[0]);
        }
    }

    protected function assertItemEntity($item): void
    {
        $this->assertUniqueId($item->getUniqueId());
        $this->assertTitle($item->getTitle());
        $this->assertDescription($item->getDescription());
        $this->assertStatus($item->getStatus());
        $this->assertCollectionContainsInstancesOf($item->getPrices(), Price::class);
        $this->assertArrayOfString($item->getTags());
    }
}
