<?php

declare(strict_types=1);

use App\Collection\CustomerCollection;
use PHPUnit\Framework\TestCase;

final class CustomerCollectionTest extends TestCase
{
    public function testnbCustomer(): void
    {
        $nbCustomer = 5;
        $customers = new CustomerCollection();
        $results = $customers->getAll($nbCustomer);

        $this->assertSame($nbCustomer, count($results));
    }

    public function testGrandnbCustomer(): void
    {
        $nbCustomer = 5000;
        $customers = new CustomerCollection();
        $results = $customers->getAll($nbCustomer);

        $this->assertSame($nbCustomer, count($results));
    }

    public function testStructureDeChaqueCustomer(): void
    {
        $nbCustomer = 5000;
        $customers = new CustomerCollection();
        $results = $customers->getAll($nbCustomer);

        for ($i = 0; $i < count($results); $i++) {
            $Customer = $results[$i];
            $this->assertIsArray($Customer);
            $this->assertArrayHasKey("firstname", $Customer);
            $this->assertArrayHasKey("lastname", $Customer);
            $this->assertArrayHasKey("address", $Customer);
            $this->assertIsArray($Customer["address"]);
            $this->assertArrayHasKey("phone", $Customer);
            $this->assertArrayHasKey("email", $Customer);
            $this->assertArrayHasKey("customer_id", $Customer);
            $this->assertArrayHasKey("birthdate", $Customer);
        }
    }
}
