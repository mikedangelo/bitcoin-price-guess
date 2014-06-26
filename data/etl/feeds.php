<?php

class Feeds {

   // all of our feeds listed here
   const BITSTAMP = 0;

   // details about each feed can be found here
   public $details = array();

   public function __construct() {
      $details[self::BITSTAMP]["name"] = "Bitstamp";
      $details[self::BITSTAMP]["volume_weight"] = 1.0;
   }
}
