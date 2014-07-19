#!/bin/bash

scriptdir="$( cd "$( dirname "$0" )" && pwd )"
override_time=$1
# TODO: read everything from config file. This should loop a config file. 
minimum_override_time=5

bitstamp_time=2
bitstamp_name="bitstamp"

bitfinex_time=1
bitfinex_name="bitfinex"

cd $scriptdir

if [ -n "$override_time" ]
   then
   if [ $override_time -lt $minimum_override_time ]
      then
         echo "override time to low. Defaulting"
      else
         bitstamp_time=$override_time
         bitfinex_time=$override_time
   fi
fi
   
# run each of our feeds!
./run_feed.sh $bitstamp_time $bitstamp_name "php run_bitstamp.php" & 
./run_feed.sh $bitfinex_time $bitfinex_name "php run_bitfinex.php" & 

