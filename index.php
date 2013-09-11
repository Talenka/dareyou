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
                  h2(a('victory', L('Last completed challenges'))) .
                  challengesList(true, 'r.status="accepted"', 'r.end DESC') .
                  h2(a('new', L('New challenges'))) .
                  challengesList() .
                  h2(a('top', L('Greatest challenges'))) .
                  challengesList(false, '', 'c.totalSum DESC'));

sendPageToClient(L('What are you gonna do awesome today?'),
        '<nav>' .
        (isset($client) ?
        a('start-challenge class=b', L('Start a challenge')) . ' ' : '') .
        a('about class=b', L('About')) . ' ' .
        a('faq class=b title="' . L('Frequently Asked Questions') . '"', 'FAQ') .
        '</nav>' .
        h1(L('What are you gonna do awesome today?')) .
        (isset($notice) ? '<div class=n>' . $notice . '</div>' : '') .
        $news .
        languageSelector());
