<?php
/**
 * This page shows cached content in static files
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

$ignoredFiles = array('.', '..', 'index.php');

if (substr(URL_PARAMS, 0, 6) == 'purge/') {

    $fileToPurge = substr(URL_PARAMS, 6);

    if (file_exists(CACHE_DIR . '/' . $fileToPurge) &&
        is_file(CACHE_DIR . '/' . $fileToPurge) &&
        !in_array($fileToPurge, $ignoredFiles))
        unlink(CACHE_DIR . '/' . $fileToPurge);
}

$cacheFileList = array_diff(scandir(CACHE_DIR), $ignoredFiles);

$html = '';
$totalSize = 0;

foreach ($cacheFileList as $cFile) {

    $cPath = CACHE_DIR . '/' . $cFile;
    $cSize = filesize($cPath);
    $since = NOW - filemtime($cPath);
    $totalSize += $cSize;

    $lastUpdate = ($since > ONE_DAY) ? round($since / ONE_DAY) . ' days' :
                   (($since > ONE_HOUR) ? round($since / ONE_HOUR) . ' hours' :
                    (($since > 60) ? round($since / 60) . ' minutes' : $since . ' seconds'));

    $html .= '<tr><td>' . a($cPath, $cFile) . '</td>' .
             '<td>' . $lastUpdate . ' ago</td>' .
             '<td style=text-align:right>' . round($cSize / 1000) . ' Ko</td>' .
             '<td style=text-align:right>' . a(L('admin-caches?purge/' . $cFile), 'Purge') . '</td>' .
             '</tr>';
}

$html = '<tr><td>' . sizeof($cacheFileList) . ' files</td>' .
        '<td>Last update</td>' .
        '<td style=text-align:right>Total: ' . round($totalSize / 1000) . ' Ko</td>' .
        '<td></td>' .
        '</tr>' .
        $html;

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-caches', L('Caches'))) .
                 '<table style="width:100%">' . $html . '</table>');
