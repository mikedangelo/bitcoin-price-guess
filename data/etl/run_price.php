<?php
include_once('persistence.php');
include_once('price_math.php');

$persistence = new Persistence();
$math = new Price_Math();

while (true) {
   sleep(5);

   // Grab records from database
   $conglomerate = $persistence->getConglomerate();

   // get a price with price_math
   $price = $math->calculate_price($conglomerate);

   // Save records to the database
   $persistence->setPrice($price); 
}
