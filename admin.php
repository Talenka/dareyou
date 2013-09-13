<?php
/**
 * This page is the main menu of the administration section
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 '<ul>' .
                 li(a('admin-logs', L('Logs'))) .
                 li(a('admin-users', L('Users'))) .
                 li(a('admin-challenges', L('Challenges'))) .
                 li(a('admin-operations', L('Operations'))) .
                 li(a('admin-caches', L('Caches'))) .
                 li(a('admin-test', L('Tests'))) .
                 '</ul>');
