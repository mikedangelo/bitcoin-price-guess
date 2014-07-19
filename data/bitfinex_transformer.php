<?php
include_once("schema_bitfinex.php");

class Bitfinex_Transformer {

   public function transform($json = false) {
      $obj = new Schema_Bitfinex();
      if ($json) {
         $this->set($obj, json_decode($json, true));
      }
      else {
         throw new Exception("MUST PASS IN SCHEMA");
      }
      return $obj;
   }

   private function set(&$obj, $data) {
      foreach ($data AS $key => $value) {
         if (!property_exists($obj, $key)) {
            throw new Exception("INVALID SCHEMA ELEMENT: $key");
         }
         if (is_array($value)) {
            $sub = new JSONObject;
            $sub->set($value);
            $value = $sub;
         }
         $setFunction = "set".ucfirst($key);
         $obj->$setFunction($value);
      }  

   }
}

//$tb = new Transform_Bitfinex();
//$schema = $tb->transform('{"high": "345.2"}');
//var_dump($schema);

