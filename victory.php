<?php
/**
 * Lastest validated challenge completions
 */

namespace Dareyou;

require_once 'core.php';

$body = getFromCache('data', ONE_HOUR);

if ($body === false)
    $body = cache('body',
            h1(a('victory', L('Last completed challenges'))) .
            challengesList(true, 'r.status="accepted"', 'r.end DESC', 30));

sendPageToClient(L('Last completed challenges'), $body);
