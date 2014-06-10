<?php

session_start();
header("Content-Type: application/json");

include_once('constants.php');
include_once('data.php');

if (empty($_GET))
{
   echo json_encode(array("success" => "false"));
}

$type = "";
$set = "";

if (!empty($_GET['type']) && defined(strtoupper($_GET['type'])))
{
   $type = constant(strtoupper($_GET['type']));
}

if (!empty($_GET['set']) && defined(strtoupper($_GET['set'])))
{
   $set = constant(strtoupper($_GET['set']));
}

echo retrieveData($set,$type);

function retrieveData($set,$type)
{

   $canRefresh = false;
   $pulseData = "";

   if (!empty($_SESSION['pulse_data']) && strlen($_SESSION['pulse_data']) > 2)
   {
      $pulseData = json_decode($_SESSION['pulse_data']);
      // why is pulseData timestamp in the future from now????
      // limiting to a 5 second difference currently results in
      // more like a 10-40 second difference?
      if ((strtotime("now") - $pulseData->timestamp) > 5)
      {
         $canRefresh = true;
      }
   }
   else
   {
      $canRefresh = true;
   }

   // if we can refresh, and we have a data feed to refresh, let's do it!
   if (!empty($set) && $canRefresh)
   {
      // data object needs to be internal data model
      // since each API has different data models...
      // for now, we are forcing bitstamp
      $set = BITSTAMP_BTCUSD_TICKER;
      $newbid = new Data($set);
      $data = $newbid->get();
      $_SESSION['pulse_data'] = $data;
      return $data;
   }

   return $_SESSION['pulse_data'];

} // retrieveData()



?>
