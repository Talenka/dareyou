<?php
/**
 * This page will allow to send mail to webmaster.
 *
 * @todo add contact
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = 60;

sendPageToClient(L('Contact'), h2(L('Contact')) . L('This service is under construction.'));
