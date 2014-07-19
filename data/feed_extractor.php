<?php
include_once("feeds.php");
include_once("extractor.php");

//$eb = new Extract_Bitstamp();
//$eb->extract();
//var_dump($eb->extract());

abstract class Feed_Extractor implements Extractor {

   protected $feedid = null;

   public function __construct() {
      if (is_null($this->feedid)) {
         throw new Exception("YOU MUST PROVIDE A VALUE FOR PROTECTED MEMBER feedid!");
      }
   }

   public function getFeedId() {
      $this->feedid;
   }
   
   // Should be in super class
   public function getSleepyTime() {
      return Feeds::$data[$feedid]["delay"];
   }

   public function extract() {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, Feeds::$data[$this->feedid]["url"]);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);

      return $output;
   }
}

