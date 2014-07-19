<?php

// UNUSED FOR NOW BUT WE MAY COME BACK TO THIS
// this is the bithorn model of a price
// this should be normalized from all of the
// different providers
class Bithorn_Price
{

   private $high;
   private $last;
   private $timestamp;
   private $bid;
   private $low;
   private $ask;

   private $cb;
   private $ct;


   // we need a data translation from bitstamp
   // to our internal provider
   public static function fromBitstamp($result)
   {
      if (is_string($result))
      {
         $result = json_decode($result);
      }
      $obj = new self();
      $obj->high = $result->high;
      $obj->low = $result->low;
      $obj->last = $result->last;
      $obj->timestamp = $result->timestamp;
      $obj->bid = $result->bid;
      $obj->ask = $result->ask;
      $obj->cb = base64_encode($result->last);
      $obj->ct = base64_encode(strtotime("now"));
      return $obj;

   } // fromBitstamp()


   /**
    * toArray
    * this is to provide the json returns
    */
   public function toArray()
   {
      $return = array();
      $return['high'] = $this->high;
      $return['low'] = $this->low;
      $return['last'] = $this->last;
      $return['timestamp'] = $this->timestamp;
      $return['bid'] = $this->bid;
      $return['ask'] = $this->ask;
      $return['cb'] = $this->cb;
      $return['ct'] = $this->ct;
      return $return;

   } // toArray()

} // Bithorn_Bid

   // "high": "659.00", "last": "646.00", "timestamp": "1402352733", "bid": "644.93", "vwap": "648.1", "volume": "6697.46125305", "low": "639.93", "ask": "647.19"}"

?>
