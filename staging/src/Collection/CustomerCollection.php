<?php

namespace App\Collection;

use DateTime;

final class CustomerCollection
{
    public static function getCustomerCollection($limit)
    {
        $fake = \Faker\Factory::create('fr_FR');
        $customer = array();
        for ($i = 0; $i < $limit; $i++) {
            $fake_customer = [
                "firstname"  => $fake->firstName(),
                "lastname"   => $fake->lastName(),
                "address"    => $fake->address(),
                "phone"      => $fake->mobileNumber(),
                "email"      => $fake->safeEmail(),
                "customer_id" => $fake->uuid(),
                "birthdate"  => $fake->dateTimeBetween('-30 year', '-15 years')->format(DateTime::ISO8601),
            ];
            array_push($customer, $fake_customer);
        }
        return $customer;
    }
}

// print_r(CustomerCollection::getCustomerCollection(5));
