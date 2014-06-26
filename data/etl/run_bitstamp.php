<?php
include_once('bitstamp_extractor.php');
include_once('bitstamp_transformer.php');
include_once('persistence.php');
include_once('feeds.php');


// TODO: Establish database lock for processing
$extractor = new Bitstamp_Extractor();
$transformer = new Bitstamp_Transformer();
$persistence = new Persistence();
while (true) {
   // Download data from bitstamp
   // Note that this would work much better as a queue from extractors to transformers
   $exData = $extractor->extract();
   $trData = $transformer->transform($exData);

   // Extract price and put it into prices db (id, feedid, lastprice)
   // Note that this would be better as a queue as well
   $persistence->addConglomerate(Feeds::BITSTAMP, $trData->getLast());
}
