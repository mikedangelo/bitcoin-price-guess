<?php

include_once('price.php');
$price = new Price();
$data = $price->getPrice();
echo json_encode($data);
