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

    $mailHash = $db->real_escape_string(md5(cleanUserMail($_POST['mail'])));
    $password = $db->real_escape_string(hashPassword($_POST['password']));

    $user = select('users', '*', 'mailHash="' . $mailHash . '" AND pass="' . $password . '"', 1);

    if ($user->num_rows == 1) {

        $client      = $user->fetch_object();
        $sessionId   = generateSessionId($client->id); // stored in the user's browser (cookie)
        $sessionHash = generateSessionId($sessionId); // stored in the database

        if ($db->query("UPDATE users SET session='" . $sessionHash . "' WHERE id=" . $client->id . ' LIMIT 1')) {

            sendSessionCookie($sessionId);

            $notice = L('Hello again') . ', ' . userLinkWithAvatar($client->name, $client->mailHash);

            include 'index.php';
            exit;

        } else $loginError = true;
    } else $loginError = true;
}

$html = form(usermailField(true) . userpasswordField() . submitButton(L('Log in'), 'class=t')) .
        h2('&nbsp;') . a('lost-password', L('Have you lost your password ?'));

if ($loginError) {
    $html = '<div class=w>' . L('Email or password is incorrect, please retry') . '</div>' . $html;
}

sendPageToClient(L('Login'), h1(L('Login')) . $html);
