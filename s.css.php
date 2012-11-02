<?php

$fc = 's.dev.css';

header('Content-Type: text/css');
header('Cache-Control: public');
header('Expires: '.gmdate('D, d M Y H:i:s',time()+31536000).' GMT');
header('X-Powered-By:');
header('Last-Modified: '.gmdate('D, d M Y H:i:s',filemtime($fc)).' GMT');
header('Content-Encoding: gzip');
ob_start('ob_gzhandler');

echo str_replace(array("\n","\r","\r\n",";}"," {","\t","    ",": ","; ",", "),
                 array("","","","}","{","","",":",";",","), file_get_contents($fc));

?>