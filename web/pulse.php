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

   if (!empty($_SESSION['pulse_data']))
   {
      // pulse data is stored as a string!!!!!
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

   // short circuit on can refresh if we already have given a score
   if (!empty($pulseData) && isset($pulseData->score))
   {
      $canRefresh = true;
   }


   // if we can refresh, and we have a data feed to refresh, let's do it!
   // if we can refresh and have an oustanding cast vote, let's see if we
   // can get a score!
   if ($canRefresh) //!empty($set) && $canRefresh), // USE HORNPRICE now
   {

      $score = false;
      $prediction = "";
      $oldbid = "";
      if (!empty($_SESSION['cast']) && !empty($pulseData))
      {
         $cast = $_SESSION['cast'];
         // we can only vote for the next pulse, within 500 seconds?
         if (abs($pulseData->timestamp - $cast['timestamp']) < 500)
         {
            // we can vote!
            $score = true;
            $prediction = $cast['prediction'];
            $oldbid = $pulseData->price;
         }
      }

      /*
      // data object needs to be internal data model
      // since each API has different data models...
      // for now, we are forcing bitstamp
      $set = BITSTAMP_BTCUSD_TICKER;
      $newbid = new Data($set);

      // data is stored as a string!!
      $data = $newbid->get();
      $newdata = json_decode($data);
      // newdata is now a standard object from the string
      */
      $set = HORNPRICE;
      $newbid = new Data($set);
      $data = $newbid->get();
      $newdata = json_decode($data);

      // now that we have a new bid, if we can score lets do it
      if ($score && $oldbid != $newdata->price)
      {
         $victory = false;
         if ($prediction == "upvote")
         {
            if ($newdata->price > $oldbid)
            {
               $victory = true;
            }
         }
         else if ($prediction == "downvote")
         {
            if ($newdata->price < $oldbid)
            {
               $victory = true;
            }
         }

         // we have a score, and it's either a winner or not!
         $newdata->score = $victory;
      }

      // every pulse we need to clear out the cast vote
      // if the bid has changed
      if ($pulseData->price != $newdata->price)
      {
         unset($_SESSION['cast']);
      }

      $_SESSION['pulse_data'] = json_encode($newdata);
   }

   return $_SESSION['pulse_data'];

} // retrieveData()



?>
