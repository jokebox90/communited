<?php

namespace App\Collection;

use Faker;


final class CustomerCollection
{
    const GRADE_CONTACT    = "contact";
    const GRADE_VISITOR    = "visiteur";
    const GRADE_MEMBER     = "membre";
    const GRADE_AMBASSADOR = "ambassadeur";
    const GRADE_FOUNDER    = "fondateur";
    const GRADES = [
        self::GRADE_CONTACT,
        self::GRADE_VISITOR,
        self::GRADE_MEMBER,
        self::GRADE_AMBASSADOR,
        self::GRADE_FOUNDER,
    ];

    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function getById(string $uniqueId)
    {
        return [
            "_sumùp_id" => $uniqueId,
            "unique_id" => $this->faker->uuid(),
            "firstname" => $this->faker->firstName(),
            "lastname"  => $this->faker->lastName(),
            "address"   => [
                "street"     => $this->faker->streetAddress(),
                "postalCode" => $this->faker->postCode(),
                "city"       => $this->faker->city(),
                "country"    => "France",
            ],
            "phone"     => $this->faker->phoneNumber(),
            "email"     => $this->faker->safeEmail(),
            "birthdate" => $this->faker->dateTimeBetween('-99 year', '-13 years')->format("Y-m-d"),
            "grade"     => $this->faker->randomElement(self::GRADES),
        ];
    }

    public function getAll($limit)
    {
        $customerList = array();

        for ($i = 0; $i < $limit; $i++) {
            $customerList[] = $this->getById($this->faker->uuid());
        }

        return $customerList;
    }
}
