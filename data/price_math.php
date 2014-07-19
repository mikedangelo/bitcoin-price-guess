<?php
include_once('feeds.php');

class Price_Math {

   private $feeds = null;

   public function __construct() {
      $feeds = new Feeds();
   }

   public function digest($conglomerate) {
      $price = 0.0;
      $timestamp = 0;
      $digest = array();

      if ($conglomerate != null) {
         $entries = count($conglomerate);
         foreach ($conglomerate as $entry) {
            //$feeds->details[$entry->feedid]["weight"]
            // TODO: algorithm for price will involve weighting each price by their volume 
            // (high volume is more important), adding some offset (if the ticker is 
            // generally lower or higher than others), and adding exponential decay based
            // on the time delta
            $price += $entry->price;
            if ($entry->inserttime > $timestamp) {
               $timestamp = $entry->inserttime;
            }
         }
         if ($entries != 0) {
            $price = round($price/$entries, 3);
         }
      }
      $digest["price"] = $price;
      $digest["timestamp"] = $timestamp;

      return $digest;
   }
}

/*
$p = new Price_Math();
include('conglomerate_entry.php');
$entry = new Conglomerate_Entry();
$entry->price = "134.234";
$entry2 = new Conglomerate_Entry();
$entry2->price = "24";

$price = $p->calculate_price(array($entry, $entry2));
var_dump($price);
*/

