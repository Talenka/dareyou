<?php

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('What are you gonna do awesome today?'),
        '<nav>' .
        (isset($client) ?
        '<a href=start-challenge class=b>' . L('Start a challenge') . '</a> ' : '') .
        '<a href=about class=b>' . L('About') . '</a> ' .
        '<a href=faq class=b title="' . L('Frequently Asked Questions') . '">FAQ</a>' .
        '</nav>' . h1(L('What are you gonna do awesome today?')) .
        (isset($notice) ? '<div class=n>' . $notice . '</div>' : '') .
        h2(a('victory', L('Last completed challenges'))) .
        challengesList(true, 'r.status="accepted"', 'r.end DESC') .
        h2(a('new', L('New challenges'))) .
        challengesList() .
        h2(a('top', L('Greatest challenges'))) .
        challengesList(false, '', 'c.totalSum DESC') . languageSelector());
