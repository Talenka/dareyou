<?php
/**
 * User profile editor
 * @todo update db #line 36
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToLoggedInUser();

$editionErrors = array();

if (!empty($_POST['name']) && isBetween(strlen($_POST['name']), 3, 255) &&
    (empty($_POST['mail']) || isBetween(strlen($_POST['mail']), 7, 255)) &&
    (empty($_POST['password']) || isBetween(strlen($_POST['password']), 3, 255)) &&
    (empty($_POST['password2']) || $_POST['password2'] == $_POST['password']) &&
    isFormKeyValid()) {

    if (!empty($_POST['password']) && isPasswordCommon($_POST['password']))
        $editionErrors[] = L('This password is too common, please choose another');

    if (!empty($_POST['name']) &&
        in_array(strtolower($_POST['name']), $forbiddenNames))
        $editionErrors[] = L('This user name is forbidden, please choose another');

    if (!empty($_POST['name']) &&
        selectCount('users',
                    'LOWER(name)="' . realEscapeString(strtolower($_POST['name']) . '" AND id<>' . $client->id) > 0))
        $editionErrors[] = L('This user name is already taken, please choose another');

    if (empty($editionErrors)) {
        logActivity('Profile modification');

        // update db
    }
}

sendPageToClient(L('Edit my profile'),
    h1(L('Edit my profile')) .
    form(usernameField(false, $client->name) .
         usermailField() .
         L('If you want to change your password, fill both text fields below:') .
         userpasswordField() .
         '<input type=password name=password2 maxlength=255 placeholder="' . L('CONFIRMPASSWORD') . '">' .
         '<input type=submit value="' . L('Apply modifications') . '" class=g>') .

    h2('Danger zone') .
    L('If for some mysterious reason you wish, you can ') .
    a('delete-account class=w', L('delete your account')));
