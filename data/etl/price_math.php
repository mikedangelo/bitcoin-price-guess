<?php
include_once('feeds.php');

class Price_Math {

   private $feeds = null;

   public function __construct() {
      $feeds = new Feeds();
   }

   public function calculate_price($conglomerate) {
      $price = 0.0;
      if ($conglomerate != null) {
         $entries = count($conglomerate);
         foreach ($conglomerate as $entry) {
            //$feeds->details[$entry->feedid]["weight"]
            // TODO: algorithm for price will involve weighting each price by their volume 
            // (high volume is more important), adding some offset (if the ticker is 
            // generally lower or higher than others), and adding exponential decay based
            // on the time delta
            $price += $entry->price;
         }
         if ($entries != 0) {
            $price = $price/$entries;
         }
      }
      return $price;
   }
}

/*
$p = new Price_Math();
include('../schema/conglomerate_entry.php');
$entry = new Conglomerate_Entry();
$entry->price = "134.234";
$entry2 = new Conglomerate_Entry();
$entry2->price = "24";

$price = $p->calculate_price(array($entry, $entry2));
var_dump($price);
*/

