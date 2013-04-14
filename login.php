<?php

namespace Dareyou;

require_once 'core.php';

$loginError = false;

if (isFormKeyValid() &&
    !empty($_POST['mail']) &&
    !empty($_POST['password']) &&
    strlen($_POST['mail']) < 256 &&
    strlen($_POST['password']) < 256 &&
    strlen($_POST['mail']) > 6 &&
    strlen($_POST['password']) > 2) {

    $mailHash = $db->real_escape_string( md5( cleanUserMail($_POST['mail']) ) );
    $password = $db->real_escape_string( hashPassword( $_POST['password'] ) );

    $user = $db->query("SELECT * FROM users WHERE mailHash='".$mailHash."' AND pass='".$password."' LIMIT 1");

    if ($user->num_rows == 1) {

        $client      = $user->fetch_object();

        // stored in the user's browser (cookie)
        $sessionId   = generateSessionId($client->id);

        // stored in the database
        $sessionHash = generateSessionId($sessionId);

        if ($db->query("UPDATE users SET session='" . $sessionHash . "' WHERE id=" . $client->id . ' LIMIT 1')) {

            sendSessionCookie($sessionId);

            $notice = L('Hello again') . ', ' .
                      userLinkWithAvatar($client->name, $client->mailHash);

            include 'index.php';
            exit;
        }
        else $loginError = true;
    }
    else $loginError = true;
}

$html = '<form action=login method=post>' .
        '<input type=email name=mail maxlength=255 pattern="[\w@\.]+" autofocus'
            . (empty($_POST['mail']) ? '' : ' value="' . $_POST['mail'] . '"') . ' placeholder="' . L('Email') . '" required>'
        . '<input type=password name=password maxlength=255 placeholder="' . L('Password') . '" required>'
        . '<input type=submit value="'.L('Log in').'" class=t>' .
        generateFormKey() . '</form>' .
        '<h2>&nbsp;</h2>' .
        '<a href=lost-password>' . L('Have you lost your password ?') . '</a>';

if ($loginError) {

    $html = '<div class=w>' .
            L('Email or password is incorrect, please retry') . '</div>' .
            $html;
}

sendPageToClient(L('Login'), '<h1>' . L('Login') . '</h1>' . $html);
