<?php
/**
 * Greatest challenge
 */

namespace Dareyou;

require_once 'core.php';

$html = (microtime(true) - $t)/$de;

phpinfo();

sendPageToClient(L('Greatest challenges'),
    h1(a('top', L('Greatest challenges'))) .
    challengesList(false, '', 'c.totalSum DESC', 30));
