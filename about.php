<?php

namespace Dareyou;

require_once 'core.php';

$attemptsNumber = selectCount('realizations');
$successfulAttempts = round(100 *
                            selectCount('realizations', "status='accepted'") /
                            $attemptsNumber);

$html = h2(L('About')) .
        h3(L('How it works')) .
        '<p align=justify>' . L('How it works ...') . '</p>' .
        h3(L('Some figures')) .
        '<ul>' .
        '<li>' . L('Players') . ': <b>' . selectCount('users') . '</b></li>' .
        '<li>' . L('Challenges') . ': <b>' . selectCount('challenges') . '</b></li>' .
        '<li>' . L('Attempts') . ': <b>' . $attemptsNumber . '</b> (' .
        $successfulAttempts . L('% successful') . ')</li>' .
        '<li>' . L('Bets') . ': <b>' . selectCount('bets') . '</b></li>' .
        '<li>' . L('Comments') . ': <b>' . selectCount('comments') . '</b></li>' .
        '</ul>' .
        h3(L('Under the hood')) .
        SITE_TITLE . L(' is a project of ') .
        '<a href="//boudah.pl">Boudah Talenka</a>, ' .
        '<a href="//www.gnu.org/licenses/gpl.html">' .
        L('published under the GPL3+ licence') . '</a> ' . L('and') .
        ' <a href="//github.com/talenka/dareyou">' .
        L('freely available on Github') . '</a>.';

sendPageToClient(L('About'), $html);
