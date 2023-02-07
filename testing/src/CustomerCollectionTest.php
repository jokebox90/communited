<?php

declare(strict_types=1);

require_once('../staging/CustomerCollection.php');

use PHPUnit\Framework\TestCase;

final class CustomerCollectionTest extends TestCase
{
    public function testNombreCustomer(): void
    {
        $nombreCustomer = 5;
        $collection = getCustomerCollection($nombreCustomer);

        $this->assertSame($nombreCustomer, count($collection));
    }

    public function testGrandNombreCustomer(): void
    {
        $nombreCustomer = 5000;
        $collection = getCustomerCollection($nombreCustomer);

        $this->assertSame($nombreCustomer, count($collection));
    }

    public function testStructureDeChaqueCustomer(): void
    {
        $nombreCustomer = 5000;
        $collection = getCustomerCollection($nombreCustomer);

        for ($i = 0; $i < count($collection); $i++) {
            $Customer = $collection[$i];
            $this->assertIsArray($Customer);
            $this->assertArrayHasKey("firstname", $Customer);
            $this->assertArrayHasKey("lastname", $Customer);
            $this->assertArrayHasKey("address", $Customer);
            $this->assertArrayHasKey("phone", $Customer);
            $this->assertArrayHasKey("email", $Customer);
            $this->assertArrayHasKey("customer_id", $Customer);
            $this->assertArrayHasKey("birthdate", $Customer);
            
        }
    }
}
