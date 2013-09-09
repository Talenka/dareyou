<?php
/**
 * List of newest challenges
 */

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('New challenges'), h1(a('new', L('New challenges'))) .
    challengesList(false, '', 'c.created DESC', 30));
