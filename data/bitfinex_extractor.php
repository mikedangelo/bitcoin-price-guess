<?php
include_once("feeds.php");
include_once("feed_extractor.php");

class Bitfinex_Extractor extends Feed_Extractor {

   protected $feedid = Feeds::BITFINEX_BTCUSD_TICKER;

}
$eb = new Bitfinex_Extractor();
$eb->extract();
var_dump($eb->extract());

