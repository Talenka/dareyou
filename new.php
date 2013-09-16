<?php
/**
 * List of newest challenges
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = ONE_HOUR;

$body = getFromCache('body', ONE_HOUR);

if ($body === false)
    $body = cache('body',
            h1(L('New challenges')) .
            challengesList(false, '', 'c.created DESC', 30));

sendPageToClient(L('New challenges'), $body);
