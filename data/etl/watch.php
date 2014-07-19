<?php

//// This script monitors system time and runs a command every so often as specified by the delay.
// This is unused but cool so i'm checking it in

//200 ms sleep between checks
$sleep=0.2;
//when no argument is provided, use this as default delay.
$defaultdelay=5;
//caluclate delay
$delay=(!empty($argv[1]) && $argv[1] > ($sleep)) ? $argv[1] : $defaultdelay;
//time moni
$time=$oldtime=time();

while (true) {
   $time = time();
   if ($time == $oldtime+$delay) {
      $oldtime = $time;
      // run command
   }
   usleep($sleep*100000);;
}
