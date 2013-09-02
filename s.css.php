<?php
/**
 * This script returns the CSS styles properly cached and minified.
 */

namespace Dareyou;

// CSS class name meanings :
// .b = button
// .g = green
// .t = turquoise
// .n = notice
// .w = warning
// .u = user

$fc = 's.dev.css';

header('Content-Type: text/css');
header('Cache-Control: public');
header('Expires: ' . date('r', time() + 31536000)); // CSS expires in 1 year
header('X-Powered-By:');
header('Last-Modified: ' . date('r', filemtime($fc)));
header('Content-Encoding: gzip');

ob_start('ob_gzhandler');

echo str_replace(array("\n", ';}', ' {', "\t", '    ', ': ', '; ', ', '),
                 array('',   '}',  '{',  '',   '',     ':',  ';',  ','),
                 file_get_contents($fc));
