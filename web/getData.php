<?php

include_once('constants.php');
include_once('data.php');


// This file provides a non local ajaxy connection to data in json.
$data = new Data();
// type will be ticker or eventually something else
$type = strtoupper($_GET['type']);
// this is the ticker sets defined in constants!
// should also (eventually) accept multiple sets or nothing for everything
$set = strtoupper($_GET['set']);
// TODO: need to add in the type checking
if (defined($set)) {
	echo $data->get($type, $set);
}

?>
