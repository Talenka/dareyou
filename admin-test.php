<?php
/**
 * This page is only for test purpose
 *
 * @todo implement edition
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

// $iterations = 100000;

// $hash = '6633d3b31bf408d13ac270a5664bcd62';

// $start = microtime(true);

// for ($i = 0; $i < $iterations; $i++) { 
//     $h = base_convert($hash, 16, 36);
// }

// $middle = microtime(true);

// for ($i = 0; $i < $iterations; $i++) { 
//     $h = substr($hash, 0, 8);
// }

// $end = microtime(true);

// echo 'Test1 : ' . ($middle - $start) . ' µs<br>' .
//      'Test2 : ' . ($end - $middle) . ' µs<br>';

echo phpinfo();
