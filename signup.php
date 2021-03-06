<?php
/**
 * Sign up form
 */

namespace Dareyou;

require_once 'core.php';

$signupError = array();

if (!empty($_POST['name']) &&
    !empty($_POST['mail']) &&
    !empty($_POST['password']) &&
    !empty($_POST['password2']) &&
    isBetween(strlen($_POST['name']), 3, 255) &&
    isBetween(strlen($_POST['mail']), 7, 255) &&
    isBetween(strlen($_POST['password']), 3, 255) &&
    isBetween(strlen($_POST['password2']), 3, 255) &&
    isFormKeyValid()) {

    if ($_POST['password'] != $_POST['password2'])
        $signupError[] = L('Password and its confirmation does not match');

    else {

        $name = realEscapeString(cleanUserName($_POST['name']));
        $mailHash = md5(realEscapeString(cleanUserMail($_POST['mail'])));
        $pass = realEscapeString(hashPassword($_POST['password']));

        if (in_array(strtolower($_POST['name']), $forbiddenNames))
            $signupError[] = L('This name is forbidden, please choose another');

        else {

            $user = select('users', '*', 'name="' . $name . '"');

            if ($user->num_rows > 0)
                $signupError[] = L('This name is already used by another user');
        }

        $user = select('users', '*', 'mailHash="' . $mailHash . '"');

        if ($user->num_rows > 0)
            $signupError[] = L('This email is already used by another user');

        if (isPasswordCommon($_POST['password']))
            $signupError[] = L('This password is too common, please choose another');

        if (sizeof($signupError) == 0) {

            if (dbInsert('users', 'name,mailHash,pass,session,karma', "VALUES ('$name','$mailHash','$pass','',20)")) {

                $newId     = $db->insert_id;
                $sessionId = generateSessionId($newId);

                if (dbUpdate('users', "session='$sessionId'", 'id=' . $newId)) {

                    sendSessionCookie($sessionId);

                    logActivity(ucfirst($name) . ' has dared to sign up', '', true);

                    redirectTo(HOME);
                }
            }
        }
    }
}

if (!empty($client))
    $html = '<p>' . L('Hey it seems you are already logged in') . ', ' . userLink($client->name) . '.</p>' .
            '<p>' . L('Don’t you seek rather to log out?') . ' &rarr; ' . a('logout class=b', L('Log out')) . '</p>';

else $html = ((sizeof($signupError) > 0) ? '<p class=w>' . implode('. ', $signupError) . '</p>' : '') .
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
        (isHttps() ? '' : li(a('https://' . SERVER_NAME . PHP_FILE,
                               L('To protect your privacy, you should use the encrypted version of this website'))));
        '</ul>';

sendPageToClient(L('Signup'), h1(L('Signup')) . $html);
