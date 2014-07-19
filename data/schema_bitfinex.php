<?php

/**
 * schema for bitfinex raw data
 * string(158) "{"mid":"626.685","bid":"626.4","ask":"626.97","last_price":"626.03","low":"616.96","high":"633.6","volume":"4385.86722621","timestamp":"1405785730.824060854"}"
 */
class Schema_Bitfinex {

   private $mid = "";
   private $high = "";
   private $last_price = "";
   private $timestamp = "";
   private $bid = "";
   private $volume = "";
   private $low = "";
   private $ask = "";

   public function getMid() {
      return $this->mid;
   }
   public function getHigh() {
      return $this->high;
   }
   public function getLast_price() {
      return $this->last_price;
   }
   public function getTimestamp() {
      return $this->timestamp;
   }
   public function getBid() {
      return $this->bid;
   }
   public function getVolume() {
      return $this->volume;
   }
   public function getLow() {
      return $this->low;
   }
   public function getAsk() {
      return $this->ask;
   }

   public function setMid($mid) {
      $this->mid = $mid;
   }
   public function setHigh($high) {
      $this->high = $high;
   }
   public function setLast_price($last_price) {
      $this->last_price = $last_price;
   }
   public function setTimestamp($timestamp) {
      $this->timestamp = $timestamp;
   }
   public function setBid($bid) {
      $this->bid = $bid;
   }
   public function setVolume($volume) {
      $this->volume = $volume;
   }
   public function setLow($low) {
      $this->low = $low;
   }
   public function setAsk($ask) {
      $this->ask = $ask;
   }

}
