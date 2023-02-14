<?php

declare(strict_types=1);

namespace Tests\Unit\Repository;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use PHPUnit\Framework\Attributes\Group;
use Tests\Base\RepositoryTestBase;


#[Group("unit")]
final class CustomerRepositoryTest extends RepositoryTestBase
{
    const AVAILABLE_STATUS = Customer::AVAILABLE_STATUS;

    public function testFindAll()
    {
        $customers = $this->entityManager
            ->getRepository(Customer::class)
            ->findAll();

        for ($i = 0; $i < count($customers); $i++) {
            $this->assertCustomerEntity($customers[$i]);
        }
    }

    protected function assertCustomerEntity($customer): void
    {
        $this->assertUniqueId($customer->getUniqueId());
        $this->assertFirstName($customer->getFirstName());
        $this->assertLastName($customer->getLastName());
        $this->assertEmailAddress($customer->getEmailAddress());
        $this->assertCollectionContainsInstancesOf($customer->getAddress(), CustomerAddress::class);
        $this->assertChoices($customer->getGrade(), Customer::AVAILABLE_GRADES);
        $this->assertStatus($customer->getStatus());
    }
}
