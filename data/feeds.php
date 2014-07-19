<?php

// TODO: make the init stuff a configuraiton file that gets used by the bash script and by php

Feeds::init();

class Feeds {

   // all of our feeds listed here
   const BITSTAMP_BTCUSD_TICKER = 0;

   // data about each feed can be found here
   public static $data = array();

   public static function init() {
      self::$data[self::BITSTAMP_BTCUSD_TICKER]["name"] = "Bitstamp BTCUSD Ticker";
      self::$data[self::BITSTAMP_BTCUSD_TICKER]["delay"] = "2";
      self::$data[self::BITSTAMP_BTCUSD_TICKER]["url"] = "https://www.bitstamp.net/api/ticker/";
      self::$data[self::BITSTAMP_BTCUSD_TICKER]["volume_weight"] = 1.0;
   }
}