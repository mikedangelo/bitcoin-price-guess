<?php

include_once('constants.php');
include_once('bithorn_bid.php');

class Data
{

   private $set;

   public function __construct($set)
   {
      $this->set = $set;
   }

   public function get()
   {
      if (!empty($this->set))
      {
         $url = $this->set;

         // Initializing curl
         $ch = curl_init($url);

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_HTTPGET, true);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json',
             'Accept: application/json'
         ));

         // Getting results
         $result = curl_exec($ch); // Getting jSON result string

         // since we are hardcoding from bitstamp for right now
         // ignore other providers
         return $result;
      }
      return json_encode(array());
   }
}
?>
