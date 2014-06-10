<?php
session_start();
header("Content-Type: application/json");

// only accessible by post
if (empty($_POST) || empty($_SESSION['pulse_data']))
{
   header("Location: index.php");
   exit;
}

// determine if we can appropriately align with a vote
$timestamp = "";
$currentbid = "";
$prediction = "no-op";
$user = "";


// do the timestamp
if (!empty($_POST) && !empty($_POST['ct']))
{
   $tstamp = base64_decode($_POST['ct']);
   if (intval($tstamp) > 0 && abs(strtotime("now") - $tstamp) < 10)
   {
      $timestamp = $tstamp;
   }
}


// do the currentbid
if (!empty($_POST) && !empty($_POST['cb'])) 
{
   $cbid = base64_decode($_POST['cb']);
   // session bid must match within 1 point
   $pulseData = json_decode($_SESSION['pulse_data']);
   $sbid = $pulseData->bid;
   if (intval($cbid) > 0 && abs($cbid - $sbid) < 1)
   {
      $currentbid = $cbid;
   }
}


// grab the prediction
if (!empty($_POST) && !empty($_POST['prediction']))
{
   if ($_POST['prediction'] == "upvote" || $_POST['prediction'] == "downvote")
   {
      $prediction = $_POST['prediction'];
   }
}

$user = hash('sha256',$_SERVER['REMOTE_ADDR']);


// determine if we can continue
if (!empty($timestamp) && !empty($currentbid) && $prediction != "no-op" && !empty($user))
{
   // now that we can continue, let's store the vote in session for now
   // until the next pulse so we can determine the winner
   $_SESSION['cast'] = array('timestamp' => $timestamp,
      'currentbid' => $currentbid,
      'prediction' => $prediction,
      'user' => $user,
      'delay' => 0
   );
   echo json_encode(array('status' => 'success', 'bidId' => uniqid()));
}
else
{
   if (!empty($_SESSION['cast']))
   {
      echo json_encode(array('status' => 'nobid', 'message' => 'You already have placed a prediction of '. $_SESSION['cast']['prediction'] .'!'));
   }
   else if (empty($currentbid))
   {
      echo json_encode(array('status' => 'nobid', 'message' => 'The bids are currently the same'));
   }
   else
   {
      echo json_encode(array('status' => 'error'));
   }
}
exit;


?>
