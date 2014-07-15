<?php
include_once('pfs.php');


$pfs = new PFS();


while (true) {

   $pfs->insert_record(PFS::EXTRACTED, "asdf");
   $pfs->insert_record(PFS::EXTRACTED, "asdf");
   $pfs->insert_record(PFS::EXTRACTED, "asdf");
   $pfs->insert_record(PFS::EXTRACTED, "asdf");

   $records = $pfs->retrieve_records(PFS::EXTRACTED);

var_dump($records);
   
   sleep(5);


}
