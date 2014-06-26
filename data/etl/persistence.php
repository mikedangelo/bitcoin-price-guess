<?php
include_once('../schema/conglomerate_entry.php');

class Persistence {

   public function __construct() {
      $username = "root";
      $password = "p24reb";
      mysql_connect("localhost",$username,$password);
   }

   public function __destruct() {
      mysql_close();
   }

   public function setPrice($price) {
      $query = "INSERT INTO bithorn.price SET price = '$price';";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function addConglomerate($feedid, $price) {
      $query = "INSERT INTO bithorn.price_conglomerate (feedid, price) VALUES ('$feedid', '$price')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function getConglomerate() {
      $conglomerate = array();
      $query = "SELECT * FROM (select * from bithorn.price_conglomerate ORDER BY id DESC LIMIT 20) pc GROUP BY feedid";
      $result = mysql_query($query);
      if ($result) {
         if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
               $entry = new Conglomerate_Entry();
               $entry->id = $row['id'];
               $entry->feedid = $row['feedid'];
               $entry->inserttime = $row['inserttime'];
               $entry->price = $row['price'];
               array_push($conglomerate, $entry);
            }
         } else {
            throw new Exception("NO RECORDS AVAILABLE TO DETERMINE PRICE!");
         }
      } else {
         throw new Exception("DB RETRIEVAL ERROR");
      }
      return $conglomerate;
   }
} 

