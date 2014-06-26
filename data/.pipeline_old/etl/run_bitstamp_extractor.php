<?php
include_once('extract_bitstamp.php');
include_once('../tools/pfs.php');

$pfs = new PFS();
$bitstamp = new Extract_Bitstamp();

$extractedOld = "";
while (true) {
   $extracted = $bitstamp->extract();
   if (strcmp($extracted, $extractedOld) !== 0) {
      $pfs->insert_record(PFS::EXTRACTED, $extracted, $bitstamp->getFeedId());
      $extractedOld = $extracted;
   }
   $bitstamp->sleep();
}
