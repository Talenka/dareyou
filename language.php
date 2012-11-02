<?php

include 'core.php';

$l = strtolower(preg_replace("/[^a-zA-Z]/", "", $_SERVER['QUERY_STRING']));

if(file_exists("lang.".$l.".php")) setcookie("lang", $l, time()+31536000);

redirectTo('.');

?>