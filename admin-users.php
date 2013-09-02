<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

$usersList = select('users');

$html = '<ul>';

while ($u = $usersList->fetch_object()) {

    $html .= li(userLinkWithAvatar($u->name, $u->mailHash) . ' ' .
             karmaButton($u->name, $u->karma));
}

$html .= '</ul>';

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-users', L('Users'))) .
                 $html);
