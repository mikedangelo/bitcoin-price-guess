<?php

$pfs = new PFS();
$pfs->insert_extraction(0, "adsfkjlsdjf");
$ret = $pfs->retrieve_extractions(0, 0);
var_dump($ret);
$pfs->insert_extraction(0, "new");
$pfs->insert_extraction(1, "new");
$pfs->insert_extraction(99, "new");
var_dump($pfs->retrieve_extractions($ret["lastid"]));

/**
 * This class serves as the file system for the pipeline
 */
class PFS {

   public function __construct() {
      $username = "root";
      $password = "p24reb";
      mysql_connect("localhost",$username,$password);
   }

   public function __destruct() {
      mysql_close();
   }

   // Inserts rawdata for a given feed (STAGE 1 OUTPUT)
   public function insert_extraction($feedid, $data) {
      $this->insert("extractions", $feedid, $data);
   }

   // Retrieves rawdata and and feedid from the last seen id (STAGE 2 INPUT)
   public function retrieve_extractions($lastid) {
      return $this->retrieve("extractions", $lastid);
   }

   // inserts tranformed data (STAGE 2 OUTPUT)
   public function insert_transform($feedid, $data) {
      $this->insert("transforms", $feedid, $data);
   }

   // retrieves transformed data (STAGE 3 INPUT)
   public function retrieve_transforms($lastid) {
      return $this->retrieve("transforms", $lastid);
   }

   // SPECIAL NOTE: approaching this a bit incorrectly.
   // the transform stages need to be thought out FAR better.
   // Inserts 
   public function insert_load($data) {
      $this->insert("loads", "0", $data);
   }

   public function insert($table, $feedid, $data) {
      $query = "INSERT INTO bithorn.$table (feedid, data) VALUES ('$feedid', '$data')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function retrieve($table, $lastid) {
      $query = "SELECT id, feedid, data FROM bithorn.$table WHERE id>'$lastid'";
      $result = mysql_query($query);

      $ret["lastid"] = $lastid;
      $ret["records"] = array();
      
      if ($result && mysql_num_rows($result)) {
         while ($row = mysql_fetch_assoc($result)) {
            if ($row["id"] > $ret["lastid"]) {
               $ret["lastid"] = $row["id"];
            }
            if (empty($ret["records"][$row["feedid"]])) {
               $ret["records"][$row["feedid"]] = array();
            }
            $ret["records"][$row["feedid"]][$row["id"]] = $row["data"];
         }
      }
      
      return $ret;
   } 

} 

