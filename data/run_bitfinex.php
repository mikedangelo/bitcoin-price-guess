<?php
include_once('bitfinex_extractor.php');
include_once('bitfinex_transformer.php');
include_once('price.php');
include_once('feeds.php');

// TODO: Establish database lock for processing
$extractor = new Bitfinex_Extractor();
$transformer = new Bitfinex_Transformer();

// TODO: make file behaviors more generic
$price = new Price();

// Download data from bitfinex
// Note that this would work much better as a queue from extractors to transformers
$exData = $extractor->extract();
$trData = $transformer->transform($exData);

// Extract price and put it into prices db (id, feedid, lastprice)
// Note that this would be better as a queue as well
$price->addConglomerate(Feeds::BITFINEX_BTCUSD_TICKER, $trData->getLast_price());
