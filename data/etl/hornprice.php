<?php

include_once('price.php');
$price = new Price();
$bid = $price->getPrice();
$array = array("bid"=>"$bid");
echo json_encode($array);
