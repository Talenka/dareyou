<?php
/**
 * Home page
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = 10;

$news = getFromCache('news', 60);

if ($news === false)
    $news = cache('news',
                  '<nav>' .
                  (isset($client) ?
                   a('start-challenge', L('Start a challenge')) . ' ' : '') .
                  a('about', L('About')) . ' ' .
                  a('faq title="' . L('Frequently Asked Questions') . '"', 'FAQ') .
                  '</nav>' .
                  h1(L('What are you gonna do awesome today?')) .
                  h2(a('victory', L('Last completed challenges'))) .
                  challengesList(true, 'r.status="accepted"', 'r.end DESC') .
                  h2(a('new', L('New challenges'))) .
                  challengesList() .
                  h2(a('top', L('Greatest challenges'))) .
                  challengesList(false, '', 'c.totalSum DESC') .
                  languageSelector());

sendPageToClient(L('What are you gonna do awesome today?'),
                 (isset($notice) ? '<div class=n>' . $notice . '</div>' : '') .
                 $news);
