<?php
namespace App\Collection;

use Faker;
final class MerchantCollection{
    private $faker;

    const FINANCE    = "bnp paris";
    const FOOD    = "McDonald's";
    const TRAINING     = "Basic fit";
    const GAMING = "Micromania";
   
    const COMPANY = [
        self::FINANCE,
        self::FOOD,
        self::TRAINING,
        self::GAMING,
    ];
    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function getById(string $uniqueId)
    {
        return [
            "_sumùp_id" => $uniqueId,
            "unique_id" => $this->faker->uuid(),
            "company_name"     => $this->faker->randomElement(self::COMPANY),
            "website" => $this->faker->domainName(),
            "iban" =>$this->faker->iban(),
            "address"   => [
                "street"     => $this->faker->streetAddress(),
                "postalCode" => $this->faker->postCode(),
                "city"       => $this->faker->city(),
                "country"    => "France",
            ],
            "phone"     => $this->faker->phoneNumber(),
            "email"     => $this->faker->safeEmail(),
        ];
    }
}
