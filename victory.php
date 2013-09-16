<?php
/**
 * Lastest accepted challenges realizations
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = ONE_HOUR;

$body = getFromCache('body', ONE_HOUR);

if ($body === false)
    $body = cache('body',
            h1(L('Last completed challenges')) .
            challengesList(true, 'r.status="accepted"', 'r.end DESC', 30));

sendPageToClient(L('Last completed challenges'), $body);
