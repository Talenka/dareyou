<?php
/**
 * Tool for reinitialize user password
 */

namespace Dareyou;

require_once 'core.php';

if (URL_PARAMS != '') {

    $reinitializationLink = explode('-', URL_PARAMS);

    if (sizeof($reinitializationLink) != 3) {
        $error = 'This reinitialization link is probably corrupted';
    } else {
        list($mailHash, $shipDate, $controlHash) = $reinitializationLink;

        $mailHash = base_convert($mailHash, 36, 16);
        $shipDate = base_convert($shipDate, 36, 10);

        if (NOW - $shipDate > 21600) {
            $error = 'This reinitialization link have expired (it is more than 6 hours old). Please get a new one.';

        } elseif (hashText($shipDate . $mailHash . $_SERVER['REMOTE_ADDR']) != $controlHash) {
            $error = 'This reinitialization link is probably corrupted ' .
                      'or your IP address have changed since it was sent.';

        } else {
            $error = 'You can reinitialize your password now, maybe... XD';

        }

    }

} elseif (isFormKeyValid() &&
    !empty($_POST['mail']) &&
    strlen($_POST['mail']) < 256 &&
    strlen($_POST['mail']) > 6) {

    $mailHash = realEscapeString(md5(cleanUserMail($_POST['mail'])));

    $user = select('users', '*', 'mailHash="' . $mailHash . '"', 1);

    if ($user->num_rows == 1) {

        $reinitializationUrl = $_SERVER['SERVER_NAME'] . substr(PHP_FILE, 0, -4) .
            '?' . base_convert($mailHash, 16, 36) . '-' . base_convert(NOW, 10, 36) . '-' .
            hashText(NOW . $mailHash . $_SERVER['REMOTE_ADDR']);

        if (sendEmail($_POST['mail'], 'Password reinitialization',
            'You have requested the reinitialization of your password on ' .
            SITE_TITLE . '<br><br>To proceed, follow this link and follow the ' .
            'instructions:<br><br>' .
            a('"' . 'http' . (isHttps() ? 's' : '') . '://' . $reinitializationUrl . '"', $reinitializationUrl) .
            '<br><br>Have a nice day.<br><br>The team.')) {

            $notice = L('The reinitialization link have been sent to you, please check your inbox');

            logActivity('Password reinitialization link sent', 'mailto:' . $_POST['mail']);

            include 'index.php';
            exit;

        } else $error = 'Sorry, we cannot send you the reinitialization mail for the moment...';

    } else $error = 'There is no user with this email address on ' . SITE_TITLE;
}

sendPageToClient(L('Lost password'),
    h2(L('Have you lost your password ?')) .
        (empty($error) ? '' : '<p class=w>' . $error . '</p>') .
        form(usermailField() . submitButton(L('Send me a link to reinitialize my password'), 'class=g')));
