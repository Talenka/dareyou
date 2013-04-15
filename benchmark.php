<?php

$fc = 's.dev.css';
$str = true;
$nbr = 1000000;

$fileContent = file_get_contents($fc);

$start = microtime(true);

// Solution A :

for ($i = 0; $i < $nbr; $i++) {

     $str = ($_SERVER['HTTPS'] == 'on');
}

$end = microtime(true);

// Solution B :

for ($i = 0; $i < $nbr; $i++) {

     $str = ($_SERVER['HTTPS'] == 'on') ? true : false;
}

$end2 = microtime(true);

echo 'A : ', round(($end - $start) * 1000), '<br>',
     'B : ', round(($end2 - $end) * 1000);