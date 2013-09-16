<?php
/**
 * Greatest challenges
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = ONE_HOUR;

$body = getFromCache('body', ONE_HOUR);

if ($body === false)
    $body = cache('body',
            h1(L('Greatest challenges')) .
            challengesList(false, '', 'c.totalSum DESC', 30));

sendPageToClient(L('Greatest challenges'), $body);
