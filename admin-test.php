<?php
/**
 * This page is only for test purpose
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

if (URL_PARAMS == 'phpinfo')

    // Display PHP and SERVER configuration informations.
    die(phpinfo());

elseif (URL_PARAMS == 'run-comparison') {

    // Run wildly two codes samples and compares the time to compute.
    $iterations = 100000;

    $hash = '6633d3b31bf408d13ac270a5664bcd62';

    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++)
        $h = base_convert($hash, 16, 36);

    $middle = microtime(true);

    for ($i = 0; $i < $iterations; $i++)
        $h = substr($hash, 0, 8);

    $end = microtime(true);

    echo 'Test1 : ' . ($middle - $start) . ' µs<br>' .
         'Test2 : ' . ($end - $middle) . ' µs<br>';

} elseif (URL_PARAMS == 'run-urls-test') {

    /**
     * @var array List of 'relative Url' => 'expected status code'
     */
    $pagesList = array('about' => '200 OK',
                       'admin' => '403 Forbidden',
                       'challenge?Manger+une+clef' => '200 OK',
                       'challenges.atom' => '200 OK',
                       'contact' => '200 OK',
                       'delete-account' => '403 Forbidden',
                       'doc/' => '200 OK',
                       'edit-profile' => '403 Forbidden',
                       'error?test' => '500 Internal Server Error',
                       'faq' => '200 OK',
                       'index' => '200 OK',
                       'login' => '200 OK',
                       'logout' => '403 Forbidden',
                       'lost-password' => '200 OK',
                       'new' => '200 OK',
                       'prize' => '200 OK',
                       'user?boudah' => '200 OK',
                       'robots.txt' => '200 OK',
                       'search?test' => '200 OK',
                       'signup' => '200 OK',
                       'sitemap.xml' => '200 OK',
                       'start-challenge' => '403 Forbidden',
                       'top' => '200 OK',
                       'victory' => '200 OK');

    $report = array();

    $iterations = 8;

    for ($i = 0; $i < $iterations; $i++) {
        foreach ($pagesList as $page => $expectedStatus) {

            if (!isset($report[$page]) || $report[$page]['status'] == '200 OK') {

                $pageUrl = 'http://' . SERVER_NAME . '/' . $page;

                $remoteHeadering = get_headers($pageUrl, 1);

                $start = microtime(true);

                $remoteOpening = @file_get_contents($pageUrl);

                if (isset($report[$page]))
                    $report[$page]['time'] += microtime(true) - $start;

                else $report[$page] = array('status' => substr($remoteHeadering[0], 9),
                                              'time' => microtime(true) - $start,
                                              'size' => strlen($remoteOpening));
            }
        }
    }

    $result    = '<table style="width:100%">';
    $totalTime = 0;
    $totalSize = 0;

    foreach ($report as $page => $data) {

        // We strip "HTTP/1.1 " from status
        $pageStatus = $data['status'];

        if ($pageStatus != $pagesList[$page])
            $pageStatus = '<span style=color:red>' . $pageStatus . '</span>';

        $pageSize = round($data['size'] / 1000, 1);

        if ($pageSize > 10)
            $pageSize = '<span style=color:red>' . $pageSize . '</span>';

        if ($pageSize > 3)
            $pageSize = '<span style=color:#da0>' . $pageSize . '</span>';

        $pageTime = round($data['time'] / $iterations * 1000);

        if ($pageTime > 500)
            $pageTime = '<span style=color:red>' . $pageTime . '</span>';

        if ($pageTime > 300)
            $pageTime = '<span style=color:#da0>' . $pageTime . '</span>';

        $result .= '<tr><td>' . a($page, $page) . '</td>' .
                   '<td style=text-align:right>' . $pageTime . ' ms</td>' .
                   '<td style=text-align:right>' . $pageSize . ' Ko</td>' .
                   '<td style=text-align:right>' . $pageStatus . '</td>';

        $totalTime += $data['time'];
        $totalSize += $data['size'];
    }

    $result .= '<tr><td>Total: ' . sizeof($pagesList) . ' urls</td>' .
               '<td style=text-align:right>' . round($totalTime / $iterations * 1000) . ' ms</td>' .
               '<td style=text-align:right>' . round($totalSize / 1000, 1) . ' Ko</td>' .
               '<td></td>' .
               '</tr>' .
               '</table>';

    sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 '<nav>' . $iterations . ' iterations, ∆N/N = ' .
                 round(100 / sqrt($iterations)) . '%</nav>' .
                 h2(a('admin-test', L('Tests'))) .
                 $result);

} elseif (URL_PARAMS == 'run-unit-tests') {

    unitTest(true, 'isBetween', 5, 2, 10);
    unitTest(false, 'isBetween', 5, 2, 4);
    unitTest(true, 'isBetween', 5.1, 2, 5.11);
    unitTest('exception', 'isBetween', 'a', 2, 4);

    if (isBetween()) array_push('isBetween() should return');


} else

    sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-test', L('Tests'))) .
                 '<ul>' .
                 '<li>' . a('admin-test?phpinfo', 'phpinfo()') . '</li>' .
                 '<li>' . a('admin-test?run-comparison', 'Compare two code samples') . '</li>' .
                 '<li>' . a('admin-test?run-urls-test', 'Test pages statuses and times.') . '</li>' .
                 '</ul>');
