<?php
/**
 * This page will allow to send mail to webmaster.
 *
 * @todo add contact
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = 60;

sendPageToClient(L('Contact'), h2(L('Contact')) .
                 '<p><em>' . L('This service is under construction.') . '.</em></p>' .
                 '<p>If you want informations, to be involved in the project ' .
                 'and/or to report bug, check the ' .
                 a('https://github.com/Talenka/dareyou', 'Dareyou GitHub page') . '.</p>');
