<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

/*******************************************************************************
*                                                                              *
*                   (RE)CREATING SITEMAP.XML AND ROBOTS.TXT                    *
*                                                                              *
*******************************************************************************/

$publicUrls = array(array('loc' => '', 'priority' => 1),
                    array('loc' => 'about', 'priority' => .3),
                    array('loc' => 'faq', 'priority' => .3),
                    array('loc' => 'top', 'priority' => .8),
                    array('loc' => 'victory', 'priority' => .8),
                    array('loc' => 'new', 'priority' => .8),
                    array('loc' => 'prize', 'priority' => .5));

$sql = select('challenges c', 'c.title,c.created', '', 30, 'c.created DESC');

while ($c = $sql->fetch_object()) {
    array_push($publicUrls, array('loc' => 'challenge?' . urlencode($c->title),
                                  'priority' => 0.3,
                                  'lastmod' => date('Y-m-d', $c->created)));
}

$privateUrls = array('/language',
                     '/signup',
                     '/login',
                     '/lost-password');

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
           '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' .
           ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' .
           ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"' .
           ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($publicUrls as $url)

    $sitemap .= '<url><loc>http://' . $_SERVER['SERVER_NAME'] . '/' . $url['loc'] . '</loc>' .
                (isset($url['lastmod']) ? '<lastmod>' . $url['lastmod'] . '</lastmod>' : '') .
                '<priority>' . $url['priority'] . '</priority></url>';

$sitemap .= '</urlset>';

$robots = 'User-agent: *';

foreach ($privateUrls as $url) $robots .= "\nDisallow: " . $url;

file_put_contents('sitemap.xml', $sitemap);
file_put_contents('robots.txt', $robots);
