<?php

require_once 'vendor/autoload.php';

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

// print_r(getArticleCollection(5));

// print_r(getArticleCollection(25));