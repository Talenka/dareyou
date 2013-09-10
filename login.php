<?php
/**
 * User logging in
 */

namespace Dareyou;

require_once 'core.php';

$loginError = false;

if (isFormKeyValid() &&
    !empty($_POST['mail']) &&
    !empty($_POST['password']) &&
    isBetween(strlen($_POST['mail']), 7, 255) &&
    isBetween(strlen($_POST['password']), 3, 255)) {

    $mailHash = $db->real_escape_string(md5(cleanUserMail($_POST['mail'])));
    $password = $db->real_escape_string(hashPassword($_POST['password']));

    $user = select('users', '*', 'mailHash="' . $mailHash . '" AND pass="' . $password . '"', 1);

    if ($user->num_rows == 1) {

        $client      = $user->fetch_object();
        $sessionId   = generateSessionId($client->id); // stored in the user's browser (cookie)
        $sessionHash = generateSessionId($sessionId); // stored in the database

        if ($db->query("UPDATE users SET session='" . $sessionHash . "' WHERE id=" . $client->id . ' LIMIT 1')) {

            sendSessionCookie($sessionId);

            logActivity('Login');

            $notice = L('Hello again') . ', ' . userLinkWithAvatar($client->name, $client->mailHash);

            include 'index.php';
            exit;

        } else $loginError = true;
    } else $loginError = true;

    $user->free();
}

if (!empty($client))
    $html = '<p>' . L('Hey it seems you are already logged in') . ', ' . userLink($client->name) . '.</p>' .
            '<p>' . L('Don’t you seek rather to log out?') . ' &rarr; ' . a('logout class=b', L('Log out')) . '</p>';

else $html = form(usermailField(true) .
                  userpasswordField() .
                  submitButton(L('Log in'), 'class=t')) .
             h2('&nbsp;') .
             a('lost-password', L('Have you lost your password ?')) .
             (isHttps() ? '' :
              '<br>' . a('https://' . SERVER_NAME . PHP_FILE,
                         L('To protect your privacy, you should use the encrypted version of this website')));

if ($loginError) $html = '<div class=w>' . L('Email or password is incorrect, please retry') . '</div>' . $html;

sendPageToClient(L('Login'), h1(L('Login')) . $html);
