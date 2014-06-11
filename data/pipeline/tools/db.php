<?php

$db = new Db();
$db->insert_extraction(0, "adsfkjlsdjf");
$db->retrieve_extractions(0, 0);


class Db {

   public function __construct() {
      $username = "root";
      $password = "p24reb";
      mysql_connect("localhost",$username,$password);
   }

   public function __destruct() {
      mysql_close();
   }

   public function insert_extraction($feedid, $rawdata) {
      $query = "INSERT INTO bithorn.rawfeeds (feedid, rawdata) VALUES ('$feedid', '$rawdata')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function retrieve_extractions($feedid, $timestamp) {
      $query = "SELECT * FROM bithorn.rawfeeds WHERE feedid='$feedid' AND $timestamp>'$timestamp'";//timestamp > '$timestamp' and feedid = '$feedid'";
      $result = mysql_query($query);
      var_dump($result);
   } 
}
