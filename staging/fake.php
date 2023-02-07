<?php

require_once '../vendor/autoload.php';

function getArticleCollection($limit) {
  $fake = Faker\Factory::create('fr_FR');

  $collection = array();

  for ($i = 0; $i < $limit; $i++) {
    $unArticleFakeIci = [
      "title" => $fake->sentence(5),
      "description" => $fake->paragraph(),
      "price" => $fake->randomElement([30, 60, 90, 120, 150]),
      "duration" => $fake->numberBetween(1, 5),
      "frequency" => $fake->randomElement(["semaine", "mois", "trimestre", "semestre", "annuel"])
    ];

    array_push($collection, $unArticleFakeIci);
  }

  return $collection;
}

function getCustomerCollection($limit){
  $fake = Faker\Factory::create('fr_FR');
  $customer = array();
  for($i = 0; $i < $limit; $i++){
    $fake_customer = [
      "firstname"  =>$fake->firstName(),
      "lastname"   =>$fake->lastName(),
      "address"    =>$fake->address(),
      "phone"      =>$fake->mobileNumber(),
      "email"      =>$fake->safeEmail(),
      "customer_id"=>$fake->uuid(),
      "birthdate"  =>$fake->dateTimeBetween('-30 year', '-15 years'),
    ];
    array_push($customer, $fake_customer);
  }
  return $customer;
}

print_r(getCustomerCollection(5));