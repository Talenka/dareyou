<?php
/**
 * This page shows cached content in static files
 * @todo make admin-caches.php
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

$cacheFileList = scandir(CACHE_DIR);

$html = '';

foreach ($cacheFileList as $cFile) {
    if (is_file(CACHE_DIR . '/' . $cFile)) $html .= '<li>' . $cFile . '</li>';
}

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-caches', L('Caches'))) . '<ul>' . $html . '</ul>');
