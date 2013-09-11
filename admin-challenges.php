<?php
/**
 * This page shows challenges list
 * @todo make admin-challenges.php
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

$html = '';

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-challenges', L('Challenges'))) . '<ul>' . $html . '</ul>');
