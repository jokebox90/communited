<?php

require_once 'vendor/autoload.php';

function getArticleCollection($limit) {
  $fake = Faker\Factory::create('fr_FR');

  $collection = array();
  for ($i = 0; $i < $limit; $i++) {
    $unArticleFakeIci = [
      "title" => $fake->sentence(5),
      "description" => $fake->paragraph(),
      "price" => $fake->randomDigit(),
      "duration" => $fake->numberBetween(0, 12),
    ];

    array_push($collection, $unArticleFakeIci);
  }

  return $collection;
}

// print_r(getArticleCollection(5));

// print_r(getArticleCollection(15));