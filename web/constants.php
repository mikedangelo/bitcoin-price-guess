<?php

define("BTCE", "https://btc-e.com/api/2");
define("BTCE_BTCUSD_TICKER", BTCE . "/btc_usd/ticker");

define("BITSTAMP", "https://www.bitstamp.net/api");
define("BITSTAMP_BTCUSD_TICKER", BITSTAMP . "/ticker/");

define("COINDESK", "https://api.coindesk.com/v1");
define("COINDESK_BTCUSD_TICKER", COINDESK . "/bpi/currentprice/USD.json");

# note this file is temporary. We'll come up with a better solution soon enough;
# please forgive me for I no not what i do
define("HORNPRICE", "http://data.".$_SERVER["SERVER_NAME"]."/hornprice.php");
?>
