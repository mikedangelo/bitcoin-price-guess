<?php

include_once("../../web/constants.php");

//$eb = new Extract_Bitstamp();
//$eb->extract();
//var_dump($eb->extract());

class Bitstamp_Extractor {

   protected $feedid = 1;
   protected $sleepyTime = 10;

   public function getFeedId() {
      return $this->feedid;
   }
   
   // Should be in super class
   private function sleep() {
      sleep($this->sleepyTime);
   }

   public function extract() {
      $this->sleep();

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, BITSTAMP_BTCUSD_TICKER);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);

      return $output;
   }
}

?>
