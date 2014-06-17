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

   // enum for stages
   const EXTRACTED = 0;
   const PROCESSED = 1;
   const JOINED = 2;

   public function __construct() {
      $username = "root";
      $password = "p24reb";
      mysql_connect("localhost",$username,$password);
   }

   public function __destruct() {
      mysql_close();
   }

   public function insert($stage, $data, $feedid = -1) {
      $query = "INSERT INTO bithorn.$stage (feedid, data) VALUES ('$feedid', '$data')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function retrieve($stage, $lastid = -1) {
      $query = "SELECT id, feedid, data FROM bithorn.$stage WHERE id>'$lastid'";
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

   public function insert_lastid($stage, $lastid) {
      $query = "INSERT INTO bithorn.lastid (stage, lastid) VALUES ('$stage', '$lastid') ON DUPLICATE KEY UPDATE lastid='$lastid'";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      } 
   }

   public function retrieve_lastid($stage = -1) {
      $query = "SELECT lastid WHERE stage='$stage'"; 
      $result = mysql_query($query);
   
      if ($result && mysql_num_rows($result)) {
         $row = mysql_fetch_assoc($result);
         if (!empty($row)) {
            return $row["lastid"];
         }
      }
      
      return -1;
   }


   // This is an instantaneous indicator of the price.
   // no access to volume via current feeds. not completely necessary tho.
   // In the future we could figure out a 24 hour high and 24 hour low.
   public function insert_price($data) {
      $query = "INSERT INTO bithorn.price (feedid, data) VALUES ('0', '$data')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function retrieve_price() {

// Keep working here
      $query = "SELECT data FROM bithorn.price ORDER BY id DESC";
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

