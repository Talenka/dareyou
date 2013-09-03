<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

if (empty($_SERVER['QUERY_STRING'])) {

    $usersList = select('users');

    $html = h2(a('admin-users', L('Users'))) . '<ul>';

    while ($u = $usersList->fetch_object()) {

        $html .= li(a('admin-users?' . $u->id, $u->name) . ' (' . $u->karma . '♣)');
    }

    $html .= '</ul>';

} else {

    $args = explode('/', $_SERVER['QUERY_STRING']);

    $sql = select('users', '*', 'id = ' . $db->real_escape_string((int) $args[0]), 1);

    if ($sql->num_rows == 1) {

        $userToAdmin = $sql->fetch_object();

        $html = h2(a('admin-users', L('Users') . ' #' . $userToAdmin->id . ' (' . $userToAdmin->name . ')'));

    } else redirectTo('admin-users', 404);

}

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) . $html);
