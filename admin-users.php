<?php
/**
 * This page allows admins to modify users entrees in database.
 *
 * @todo implement edition
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

if (empty($_SERVER['QUERY_STRING'])) {

    $html = h2(a('admin-users', L('Users'))) . '<ul>';

    $usersList = select('users');

    while ($u = $usersList->fetch_object()) {

        $html .= li(a('admin-users?' . $u->id .
                    ' class=u style="background-image:url(' . avatarUrl($u->mailHash, 20) . ')"',
                    ucfirst($u->name)) . ' [' . $u->karma . ' ♣]');
    }

    $usersList->free();

    $html .= '</ul>';

} else {

    $args = explode('/', $_SERVER['QUERY_STRING']);

    $sql = select('users', '*', 'id = ' . $db->real_escape_string((int) $args[0]), 1);

    if ($sql->num_rows === 1) {

        $userToAdmin = $sql->fetch_object();

        $html = h2(a('admin-users', L('Users')) .
                   ' #' . $userToAdmin->id . ' (' . $userToAdmin->name . ')');

        $html .= form(usernameField(false, $userToAdmin->name) .
                      usermailField(false, '') .
                      '<small>(' .
                      L('Leave blank the field above to keep the current mail') .
                      '</small><br>' .
                      submitButton(L('Modify user'), ' class="b w"'),
                      'admin-users?' . $userToAdmin->id) .
                 h3(L('User informations')) .
                 'Karma: ' . $userToAdmin->karma . ' ♣<br>';

    } else redirectTo('admin-users', NOT_FOUND);
}

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) . $html);
