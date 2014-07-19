#!/bin/bash

# get parameters
scriptdir="$( cd "$( dirname "$0" )" && pwd )"
delay=$1
feedname=$2
feedcommand="$3"

cd $scriptdir

# setup lock file behavior
function create {
   #ideally the lockfile will be named after a param read from config
   touch $feedname.lock
   echo $BASHPID > $feedname.lock
   chmod 440 $feedname.lock
}
function finish {
   if [ -a "$feedname.lock" ]; then
      chmod 660 $feedname.lock
      rm -r $feedname.lock
   fi
}
trap finish EXIT

# don't run if there is another already running
if [ -a "$feedname.lock" ]; then
   # this stops the finish call from executing on this exit
   trap - EXIT
   echo "$feedname.lock file exists, please cleanup previous process"
   exit
fi

create

# run script
while sleep $delay
do
      $($feedcommand &>/dev/null &)
done
