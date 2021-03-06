<?php
/**
 * This page give general informations about this website.
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = ONE_DAY;

$body = getFromCache('body', ONE_DAY);

if ($body === false) {

    $attemptsNumber = selectCount('realizations');
    $successfulAttempts = round(100 * selectCount('realizations', "status='accepted'") / $attemptsNumber);

    $body = cache('body',
                  h1(L('About')) .
                  h2(L('How it works')) .
                  '<p align=justify>' . L('How it works ...') . '</p>' .
                  h2(L('Some figures')) .
                  '<ul>' .
                  li(L('Players') . ': <b>' . selectCount('users') . '</b>') .
                  li(L('Challenges') . ': <b>' . selectCount('challenges') . '</b>') .
                  li(L('Attempts') . ': <b>' . $attemptsNumber . '</b> (' .
                     $successfulAttempts . L('% successful') . ')') .
                  li(L('Bets') . ': <b>' . selectCount('bets') . '</b>') .
                  li(L('Comments') . ': <b>' . selectCount('comments') . '</b>') .
                  '</ul>' .
                  h2(L('Under the hood')) .
                  SITE_TITLE . L(' is a project of ') . a('"//boudah.pl"', 'Boudah Talenka') . ', ' .
                  a('"//www.gnu.org/licenses/gpl.html"', L('published under the GPL3+ licence')) . ' ' . L('and') .
                  ' ' . a('"//github.com/talenka/dareyou"', L('freely available on Github')) . '.');
}

sendPageToClient(L('About'), $body);
