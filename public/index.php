<?php

require_once( './../app/core/loader.php' );

$dispatch = new TDispatch;
$dispatch->dispatch();

$dbh = TDatabase::singleton();

?>
