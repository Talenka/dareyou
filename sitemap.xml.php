<?php

namespace Dareyou;

require_once 'core.php';

header('Content-Type: application/xml');

$urls = array(array('loc' => '', 'priority' => 1),
              array('loc' => 'about', 'priority' => .3),
              array('loc' => 'faq', 'priority' => .3),
              array('loc' => 'top', 'priority' => .8),
              array('loc' => 'victory', 'priority' => .8),
              array('loc' => 'new', 'priority' => .8),
              array('loc' => 'prize', 'priority' => .5));

echo '<?xml version="1.0" encoding="UTF-8"?>' .
     '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' .
     ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' .
     ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"' .
     ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($urls as $url)

    echo '<url>' .
         '<loc>http://' . $_SERVER['SERVER_NAME'] . '/' . $url['loc'] . '</loc>' .
         (isset($url['lastmod']) ?
            '<lastmod>' . $url['lastmod'] . '</lastmod>' : '') .
         '<priority>' . $url['priority'] . '</priority>' .
         '</url>';

echo '</urlset>';