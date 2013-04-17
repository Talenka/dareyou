<?php

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Greatest challenges'),
    h1(a('top', L('Greatest challenges'))) .
    challengesList(false, '', 'c.totalSum DESC', 30));
