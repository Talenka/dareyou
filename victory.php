<?php
/**
 * Lastest validated challenge completions
 */

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Last completed challenges'),
    h1(a('victory', L('Last completed challenges'))) .
    challengesList(true, 'r.status="accepted"', 'r.end DESC', 30));
