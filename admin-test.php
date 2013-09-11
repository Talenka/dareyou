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

// echo phpinfo();

$pagesList = array('index',
                   'faq',
                   'about',
                   'error?test',
                   'search',
                   'new',
                   'victory',
                   'top',
                   'start-challenge',
                   'signup',
                   'login',
                   'prize',
                   'lost-password');

$report = array();

$iterations = 16;

for ($i = 0; $i < $iterations; $i++) {
    foreach ($pagesList as $page) {

        $start = microtime(true);

        $remoteOpening = @file_get_contents('http://' . SERVER_NAME . '/' . $page);

        if (isset($report[$page])) {
            $report[$page]['time'] += microtime(true) - $start;
            $report[$page]['size'] += strlen($remoteOpening);

        } else $report[$page] = array('time' => microtime(true) - $start,
                                      'size' => strlen($remoteOpening));
    }
}

$result    = '';
$totalTime = 0;
$totalSize = 0;

foreach ($report as $page => $data) {

    $result .= '<li>' . a($page, $page) . ' : ' .
               round($data['time'] / $iterations * 1000) . ' ms, ' .
               round($data['size'] / $iterations / 1000, 1) . ' Ko</li>';

    $totalTime += $data['time'];
    $totalSize += $data['size'];
}

$result .= '<li>Total : ' . round($totalTime / $iterations * 1000) . ' ms, ' .
               round($totalSize / $iterations / 1000) . ' Ko</li>';


sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-test', L('Tests'))) .
                 '<ul>' . $result . '</ul>');
