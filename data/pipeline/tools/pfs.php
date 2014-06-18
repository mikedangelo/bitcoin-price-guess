<?php

$pfs = new PFS();


$pfs->insert_record(PFS::EXTRACTED, "adsfkjlsdjf");
$pfs->insert_record(PFS::EXTRACTED, "adsfkjlsdjf");
$pfs->insert_record(PFS::EXTRACTED, "adsfkjlsdjf");
$ret = $pfs->retrieve_records(PFS::EXTRACTED);
var_dump($ret);

/**
 * This class serves as the file system for the pipeline
 */
class PFS {

   // enum for stages
   const EXTRACTED = "extracted";
   const PROCESSED = "processed";
   const JOINED = "joined";

   public function __construct() {
      $username = "root";
      $password = "p24reb";
      mysql_connect("localhost",$username,$password);
   }

   public function __destruct() {
      mysql_close();
   }

   public function insert_record($stage, $record, $feedid = -1) {
      $query = "INSERT INTO bithorn.$stage (feedid, data) VALUES ('$feedid', '$record')";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      }
   }

   public function retrieve_records($stage, $lastid = -1) {
      mysql_query("SET autocommit=0; LOCK TABLES bithorn.$stage READ, bithorn.lastid WRITE;");
      if ($lastid == -1) {
         $lastid = $this->retrieve_lastid($stage);
      }
      $query = "SELECT id, feedid, data FROM bithorn.$stage WHERE id>'$lastid'";
      $result = mysql_query($query);

      $ret["records"] = array();
      
      if ($result && mysql_num_rows($result)) {
         while ($row = mysql_fetch_assoc($result)) {
            if ($row["id"] > $lastid) {
               $lastid = $row["id"];
            }
            if (empty($ret["records"][$row["feedid"]])) {
               $ret["records"][$row["feedid"]] = array();
            }
            $ret["records"][$row["feedid"]][$row["id"]] = $row["data"];
         }
      }

      $this->insert_lastid($stage, $lastid);

      mysql_query("COMMIT; UNLOCK TABLES;");
      
      return $ret;
   } 

   private function insert_lastid($stage, $lastid) {
      $query = "INSERT INTO bithorn.lastid (stage, id) VALUES ('$stage', '$lastid') ON DUPLICATE KEY UPDATE id='$lastid'";
      $result = mysql_query($query);
      if (!$result) {
         throw new Exception("DB INSERTION ERROR");
      } 
   }

   private function retrieve_lastid($stage = -1) {
      $query = "SELECT id FROM bithorn.lastid WHERE stage='$stage'"; 
      $result = mysql_query($query);
   
      if ($result && mysql_num_rows($result)) {
         $row = mysql_fetch_assoc($result);
         if (!empty($row)) {
            return $row["id"];
         }
      }
      return -1;
   }

} 

