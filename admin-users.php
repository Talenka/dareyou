<?php
/**
 * This page allows admins to modify users entrees in database.
 *
 * @todo implement edition
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

if (URL_PARAMS == '') {

    $html = h2(a('admin-users', L('Users'))) . '<ul>';

    $usersList = select('users');

    while ($u = $usersList->fetch_object())

        $html .= li(a('admin-users?' . $u->id,
                      ucfirst($u->name)) . ' [' . $u->karma . ' ♣]');

    $usersList->free();

    $html .= '</ul>';

} else {

    $args = explode('/', URL_PARAMS);

    $sql = select('users', '*', 'id = ' . realEscapeString((int) $args[0]), 1);

    if ($sql->num_rows === 1) {

        if (!empty($_POST['name']) &&
            isBetween(strlen($_POST['name']), 2, 25) &&
            (!empty($_POST['mail']) ||
             isBetween(strlen($_POST['mail']), 6, 255)) &&
            isFormKeyValid()) {

            /**
             * @todo verify that these user name and/or mail are not used by anyone else !
             * @todo lowercase new user name ?
             * @todo verify that new user name is not forbidden
             */

            $newMailHash = md5($_POST['mail']);

            // $db->query('UPDATE `users` SET `name`=""' . () . ' AND `mailHash`="' . md5($_POST['mail']) . '"');

        }

        $userToAdmin = $sql->fetch_object();

        $html = h2(a('admin-users', L('Users')) .
                   ' #' . $userToAdmin->id . ' (' . $userToAdmin->name . ')');

        $html .= form(usernameField(true, $userToAdmin->name) .
                      usermailField(false, '', false) .
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
