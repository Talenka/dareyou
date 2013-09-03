<?php

namespace Dareyou;

require_once 'core.php';

$signupError = array();

if (isFormKeyValid() &&
    !empty($_POST['name']) &&
    !empty($_POST['mail']) &&
    !empty($_POST['password']) &&
    !empty($_POST['password2']) &&
    isBetween(strlen($_POST['name']), 3, 255) &&
    isBetween(strlen($_POST['mail']), 7, 255) &&
    isBetween(strlen($_POST['password']), 3, 255) &&
    isBetween(strlen($_POST['password2']), 3, 255)) {

    if ($_POST['password'] != $_POST['password2']) {
        $signupError[] = L('Password and its confirmation does not match');

    } else {

        $name = $db->real_escape_string(cleanUserName($_POST['name']));
        $mailHash = md5($db->real_escape_string(cleanUserMail($_POST['mail'])));
        $pass = $db->real_escape_string(hashPassword($_POST['password']));

        if (in_array(strtolower($_POST['name']), $forbiddenNames)) {
            $signupError[] = L('This name is forbidden, please choose another');

        } else {

            $user = select('users', '*', 'name="' . $name . '"');

            if ($user->num_rows > 0) {
                $signupError[] = L('This name is already used by another user');
            }
        }

        $user = select('users', '*', 'mailHash="' . $mailHash . '"');

        if ($user->num_rows > 0) {
            $signupError[] = L('This email is already used by another user');
        }

        if (in_array(strtolower($_POST['password']), $commonPasswords)) {
            $signupError[] = L('This password is too common, please choose another');
        }

        if (sizeof($signupError) == 0) {

            if ($db->query('INSERT INTO users (name,mailHash,pass,session,karma) ' .
                           "VALUES ('" . $name . "','" . $mailHash . "','" . $pass . "','',20)")) {

                $newId     = $db->insert_id;
                $sessionId = generateSessionId($newId);

                if ($db->query('UPDATE users SET session="' . $sessionId . '" WHERE id=' . $newId . ' LIMIT 1')) {

                    sendSessionCookie($sessionId);

                    logActivity(ucfirst($name) . ' has dared to sign up', '', true);

                    redirectTo(HOME);
                }
            }
        }
    }
}

$html = ((sizeof($signupError) > 0) ? '<p class=w>' . implode('. ', $signupError) . '</p>' : '') .
        form(usernameField(true) . usermailField() .
        userpasswordField() .
        '<input type=password name=password2 maxlength=255 ' .
            'placeholder="' . L('CONFIRMPASSWORD') . '" required>' .
        submitButton(L('Dare to sign up'), 'class=g')) .
        h3('&nbsp;') .
        '<ul>' .
        li(L('You will start with 20 karma points, you may bet with it')) .
        li(L('Just lowercase letters for your username')) .
        li(L('Your email will stay confidential, no jokes')) .
        li(L('Choose a long and unique password')) .
        li(L('We use Gravatar as your icon')) .
        '</ul>';

sendPageToClient(L('Signup'), h1(L('Signup')) . $html);
