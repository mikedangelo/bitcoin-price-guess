<?php

/**
 * Schema for bitstamp raw data
 */
class Schema_Bitstamp {

   private $high = "";
   private $last = "";
   private $timestamp = "";
   private $bid = "";
   private $vwap = "";
   private $volume = "";
   private $low = "";
   private $ask = "";

   public function getHigh() {
      return $this->high;
   }
   public function getLast() {
      return $this->last;
   }
   public function getTimestamp() {
      return $this->timestamp;
   }
   public function getBid() {
      return $this->bid;
   }
   public function getVwap() {
      return $this->vwap;
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

   public function setHigh($high) {
      $this->high = $high;
   }
   public function setLast($last) {
      $this->last = $last;
   }
   public function setTimestamp($timestamp) {
      $this->timestamp = $timestamp;
   }
   public function setBid($bid) {
      $this->bid = $bid;
   }
   public function setVwap($vwap) {
      $this->vwap = $vwap;
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
