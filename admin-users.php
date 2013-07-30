<?php

namespace Dareyou;

require_once 'core.php';

$pageTitle = L('Users administration');

$usersList = select('users');

$html = h2($pageTitle) . h3('Users list') . '<ul>';

while ($u = $usersList->fetch_object()) {

	$html .= '<li>' . userLinkWithAvatar($u->name, $u->mailHash) . ' ' .
             karmaButton($u->name, $u->karma) . '</li>';
}

$html .= '</ul>';

sendPageToClient($pageTitle, $html);
