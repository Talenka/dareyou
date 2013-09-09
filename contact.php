<?php
/**
 * This page will allow to send mail to webmaster.
 *
 * @todo add contact
 * @todo add link to github project issues ?
 */

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Contact'), h2(L('Contact')) . L('This service is under construction.'));
