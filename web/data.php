<?php

include_once('constants.php');

class Data {

function get($type, $set) {

if (defined($set)) {
$url = constant($set);

// Initializing curl
$ch = curl_init( $url );

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json'
));

// Getting results
$result = curl_exec($ch); // Getting jSON result string

//var_dump($result);
return $result;
}
}
}

?>
