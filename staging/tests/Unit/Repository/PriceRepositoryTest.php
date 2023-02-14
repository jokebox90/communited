<?php

declare(strict_types=1);

namespace Tests\Unit\Repository;

use App\Entity\Price;
use PHPUnit\Framework\Attributes\Group;
use Tests\Base\RepositoryTestBase;

#[Group("unit")]
final class PriceRepositoryTest extends RepositoryTestBase
{
    const AVAILABLE_STATUS      = Price::AVAILABLE_STATUS;

    public function testFindAll()
    {
        $Prices = $this->entityManager
            ->getRepository(Price::class)
            ->findAll();

        for ($i = 0; $i < count($Prices); $i++) {
            $this->assertPriceEntity($Prices[0]);
        }
    }

    protected function assertPriceEntity($Price): void
    {
        $this->assertUniqueId($Price->getUniqueId());
        $this->assertUniqueId($Price->getItemId());
        $this->assertAmount($Price->getAmount());
        $this->assertDescription($Price->getDescription());
        $this->assertStatus($Price->getStatus());
        $this->assertNumberBetween($Price->getDuration(), 1, 3);
        $this->assertChoices($Price->getFrequency(), Price::AVAILABLE_FREQUENCIES);
    }
}
