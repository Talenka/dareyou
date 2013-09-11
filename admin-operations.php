<?php
/**
 * This script (re)create useful static files
 */

namespace Dareyou;

require_once 'core.php';

/** @var string path of sitemap */
const SITEMAP_FILE = 'sitemap.xml';

/** @var string path of sitemap */
const ROBOT_FILE = 'robot.txt';

restrictAccessToAdministrator();

$lastChallenges = array();

$result = '';

$sql = select('challenges c, users u',
              'c.cid,c.title,c.created,c.description,u.name',
              'u.id = c.author', 30, 'c.created DESC');

while ($c = $sql->fetch_object()) array_push($lastChallenges, $c);

$sql->free();

/*******************************************************************************
*                                                                              *
*                            (RE)CREATING SITEMAP.XML                          *
*                                                                              *
*******************************************************************************/

if (!file_exists(SITEMAP_FILE) || filemtime(SITEMAP_FILE) > NOW - ONE_DAY) {

    $publicUrls = array(array('loc' => '', 'priority' => 1),
                        array('loc' => 'about', 'priority' => .3),
                        array('loc' => 'faq', 'priority' => .3),
                        array('loc' => 'top', 'priority' => .8),
                        array('loc' => 'victory', 'priority' => .8),
                        array('loc' => 'new', 'priority' => .8),
                        array('loc' => 'prize', 'priority' => .5));

    foreach ($lastChallenges as $c)

        array_push($publicUrls,
                   array('loc' => 'challenge?' . urlencode($c->title),
                         'priority' => 0.3,
                         'lastmod' => date('Y-m-d', $c->created)));

    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' .
               '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' .
               ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' .
               ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"' .
               ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($publicUrls as $url)

        $sitemap .= '<url><loc>http://' . SERVER_NAME . '/' . $url['loc'] . '</loc>' .
                    (isset($url['lastmod']) ? '<lastmod>' . $url['lastmod'] . '</lastmod>' : '') .
                    '<priority>' . $url['priority'] . '</priority></url>';

    $sitemap .= '</urlset>';
    
    $result .= li(a(SITEMAP_FILE, SITEMAP_FILE) .
                  (file_put_contents(SITEMAP_FILE, $sitemap) ? '' : ' not') . ' created') .
               li(a(SITEMAP_FILE . '.gz', SITEMAP_FILE . '.gz') .
                  (file_put_contents(SITEMAP_FILE . '.gz', gzencode($sitemap, 9)) ? '' : ' not') . ' created');

} else $result .= li(a(SITEMAP_FILE, SITEMAP_FILE) . ' was already up to date');

/*******************************************************************************
*                                                                              *
*                           (RE)CREATING ROBOTS.TXT                            *
*                                                                              *
*******************************************************************************/

if (!file_exists(ROBOT_FILE) || filemtime(ROBOT_FILE) > NOW - ONE_WEEK) {
    $privateUrls = array('/language',
                         '/signup',
                         '/login',
                         '/lost-password');

    $robots = 'User-agent: *';

    foreach ($privateUrls as $url) $robots .= "\nDisallow: " . $url;

    $robots .= "\nSitemap: /sitemap.xml";

    $result .= li(a(ROBOT_FILE, ROBOT_FILE) .
                  (file_put_contents(ROBOT_FILE, $robots) ? '' : ' not') . ' created');

} else $result .= li(a(ROBOT_FILE, ROBOT_FILE) . ' was already up to date');

/*******************************************************************************
*                                                                              *
*                          (RE)CREATING CHALLENGES.ATOM                        *
*                                                                              *
*******************************************************************************/

$feedFile = 'challenges.atom';

$feedId = md5(SERVER_NAME);
$feedId = substr($feedId, 0, 8) . '-' . substr($feedId, 8, 4) . '-' . substr($feedId, 12, 4) . '-';

$atom = '<?xml version="1.0" encoding="utf-8"?>' . "\n" .
        '<feed xmlns="http://www.w3.org/2005/Atom">' . "\n" .
        '<title>' . SITE_TITLE . '</title>' . "\n" .
        '<subtitle type="html"><![CDATA[' . L('How it works ...') . ']]></subtitle>' . "\n" .
        '<link href="http://' . SERVER_NAME .'/" />' . "\n" .
        '<link href="http://' . SERVER_NAME .'/' . $feedFile . '" rel="self" type="application/atom+xml" />' . "\n" .
        '<id>tag:' . SERVER_NAME .',2008:challenges</id>' . "\n" .
        '<updated>' . date('c', NOW) . '</updated>';

foreach ($lastChallenges as $c)
    $atom .= '<entry>' . "\n" .
             '<title>' . utf8_encode($c->title) . '</title>' . "\n" .
             '<link href="http://' . SERVER_NAME .'/challenge?' . urlencode($c->title) . '" />' . "\n" .
             '<id>tag:' . SERVER_NAME .',2008:challenge/' . $c->cid . '</id>' . "\n" .
             '<updated>' . date('c', $c->created) . '</updated>' . "\n" .
             '<summary type="html"><![CDATA[' . utf8_encode($c->description) . ']]></summary>' . "\n" .
             '<author><name>' . $c->name . '</name></author>' . "\n" .
             '</entry>';

$atom .= '</feed>';

if (file_put_contents($feedFile, $atom)) $result .= li(a($feedFile, $feedFile) . ' created');

/*******************************************************************************
*                                                                              *
*                                (RE)CREATING S.CSS                            *
*                                                                              *
*******************************************************************************/

/**
 * This script returns the CSS styles properly cached and minified.
 * CSS class name meanings :
 * .b = button
 * .g = green
 * .t = turquoise
 * .n = notice
 * .w = warning
 * .u = user
 * .i = image
 */

$styleInputFile = 's.dev.css';
$styleOutputFile = 's.css';

if (file_put_contents($styleOutputFile,
                      str_replace(array("\n", ';}', ' {', "\t", '    ', ': ', '; ', ', '),
                                  array('',   '}',  '{',  '',   '',     ':',  ';',  ','),
                                  file_get_contents($styleInputFile))))
    $result .= li(a($styleOutputFile, $styleOutputFile) . ' created');;

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-operations', L('Operations'))) .
                 '<ul>' . $result . '</h2>');
