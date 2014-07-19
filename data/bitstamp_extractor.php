<?php
include_once("feeds.php");
include_once("feed_extractor.php");

class Bitstamp_Extractor extends Feed_Extractor {

   protected $feedid = Feeds::BITSTAMP_BTCUSD_TICKER;

}

//$eb = new Bitstamp_Extractor();
//$eb->extract();
//var_dump($eb->extract());

