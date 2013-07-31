<?php

namespace Dareyou;

require_once 'core.php';

if (isFormKeyValid()) {

    $warnings = array();

    if (empty($_POST['challengeTitle'])) {
        $warnings[] = L('You have not given a challenge title');

    } elseif (strlen($_POST['challengeTitle']) < 3) {
        $warnings[] = L('Your title is too short (3 letters minimum)');

    } elseif (strlen($_POST['challengeTitle']) > 255) {
        $warnings[] = L('Your title is too long (255 letters maximum)');
    }

    if (strlen($_POST['challengeDescription']) > 65535) {
        $warnings[] = L('Your description is too long (65535 letters maximum)');
    }

    if ($_POST['challengeTimeToDo'] < 1) {
        $warnings[] = L('It takes at least 1 day to complete the challenge');
    }

    if (strlen($_POST['challengeImage']) > 255) {
        $warnings[] = L('Your image URL is too long (255 characters maximum)');
    }
}

$html = form('start-challenge',
        (empty($warnings) ? '' :
            '<div class=w>' .
            L('There are some errors that prevent starting the challenge:') .
            '<br>' . implode('<br>', $warnings) . '</div>') .
        '<input type=text name=challengeTitle maxlength=255 placeholder="' .
            L('The challenge title (simple and unique)') . '" autofocus ' .
            'pattern="\w{3,255}">' .
        '<textarea name=challengeDescription maxlength=65535 placeholder="' .
            L('Challenge description with details') . '" rows=5></textarea>' .
        '<input type=number name=challengeTimeToDo maxlength=3 min=1 max=365 ' .
            'placeholder="' . L('Time to accomplish the challenge (in days)') .
            '">' .
        '<input type=url name=challengeImage maxlength=255 placeholder="' .
            L('Challenge image URL like http://...') . '">' .
        '<input type=submit value="' . L('Start a challenge') .
            '" class=g>');

sendPageToClient(L('Start a challenge'), h1(L('Start a challenge')) . $html);
