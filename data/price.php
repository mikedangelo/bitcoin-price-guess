<?php
include_once('conglomerate_entry.php');
include_once('price_math.php');

class Price {

   private $math = null;

   public function __construct() {
      $username = "root";
      $password = "p24reb";
      mysql_connect("localhost",$username,$password);
      $this->math = new Price_Math();
   }

   public function __destruct() {
      mysql_close();
   }

   public function getPrice($feedids = array()) {
      $conglomerate = $this->getConglomerate($feedids);
      // Form price digest from conglomerate. 
      // This may eventually be saved back to the DB as part of processing
      $digest = $this->math->digest($conglomerate);
      // format
      $price = array("bid"=>$digest["price"], "timestamp"=>$digest["timestamp"]);
      return $price;
   }

   public function addConglomerate($feedid, $price) {
      $query = "INSERT INTO bithorn.price_conglomerate (feedid, price) VALUES ('$feedid', '$price')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function getConglomerate($feedids = array()) {
      $conglomerate = array();
      $feedInStatement = "";
      if (!empty($feedids)) {
         foreach ($feedids as $feedid) {
            $feedInStatement .= "'".$feedid."',";
         }
         $feedInStatement = "WHERE feedid IN (".trim($feedInStatement,",").") ";
      }
      $query = "SELECT * FROM (SELECT * FROM bithorn.price_conglomerate ".$feedInStatement."ORDER BY id DESC LIMIT 200) pc GROUP BY feedid";
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
/*$p = new Price();
$price = $p->getPrice(array(0,1));
var_dump($price);
$price = $p->getPrice(array(0));
var_dump($price);
$price = $p->getPrice();
var_dump($price);
*/
