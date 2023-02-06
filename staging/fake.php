<?php
require_once 'vendor/autoload.php';

$title=[];
$description = [];
$price = [];
$duration = [];
function fake_data($number_faker)
{
    $faker = Faker\Factory::create('fr_FR');
    for($i = 0 ; $i < $number_faker ; $i++){
        $title[] = $faker->sentence(4);
        $description[] = $faker->paragraph();
        $price[] = $faker->randomDigit();
        $duration[]= $faker->numberBetween(0, 5);
    }
    return [$title,$description,$price,$duration];
}

$result = fake_data(5);

for ($i = 0; $i < 5; $i++) {
    echo "Title: " . $result[0][$i] . "<br>";
    echo "Description: " . $result[1][$i] . "<br>";
    echo "Price: " . $result[2][$i] . "<br>";
    echo "Duration: " . $result[3][$i] . "<br>";
    echo "<br>";
}
