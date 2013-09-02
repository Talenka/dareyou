<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToLoggedInUser();

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
    } elseif ($_POST['challengeTimeToDo'] > 365) {
        // The maximum delay is 1 year:
        $_POST['challengeTimeToDo'] = 365;
    }

    if (strlen($_POST['challengeImage']) > 255) {
        $warnings[] = L('Your image URL is too long (255 characters maximum)');
    } elseif (substr($_POST['challengeImage'], 0, 4) != 'http') {
        $warnings[] = L('Your image URL look weird, it should be like <u>http://example.com/image.jpg</u>');
    }

    $_POST['challengeImage'] = preg_replace('/[^\w\/\:\-\.\(\) ]/', '', $_POST['challengeImage']);

    if (sizeof($warnings) == 0) {

        if ($db->query('INSERT INTO challenges ' .
            '(lang,title,author,description,image,created,timeToDo,forSum,againstSum,completed,totalSum) ' .
            'VALUES("' . $lang . '",' .
                    '"' . $db->real_escape_string($_POST['challengeTitle']). '",' .
                    $client->id . ',' .
                    '"' . $db->real_escape_string($_POST['challengeDescription']) . '",' .
                    '"' . $db->real_escape_string($_POST['challengeImage']) . '",' .
                    NOW . ',' .
                    '"' . $db->real_escape_string($_POST['challengeTimeToDo']) . '",' .
                    '0,0,0,0)')) {

            redirectTo('challenge?' . urlencode($_POST['challengeTitle']));

        } else $warnings[] = L('An error happen so the challenge have not been created, please retry.');
    }
}

$html = form((empty($warnings) ? '' :
        '<div class=w>' . L('There are some errors that prevent starting the challenge:') .
            '<br>' . implode('<br>', $warnings) . '</div>') .
        '<input type=text name=challengeTitle maxlength=255 placeholder="' .
            L('The challenge title (simple and unique)') . '" autofocus pattern="[\w ]{3,255}"' .
            (empty($_POST['challengeTitle']) ? '' : ' value="' . $_POST['challengeTitle'] . '"') . '>' .
        '<textarea name=challengeDescription maxlength=65535 placeholder="' .
            L('Challenge description with details') . '" rows=5>' .
            (empty($_POST['challengeDescription']) ? '' : $_POST['challengeDescription']) . '</textarea>' .
        '<input type=number name=challengeTimeToDo maxlength=3 min=1 max=365 ' .
            'placeholder="' . L('Time to accomplish the challenge (in days)') . '"' .
            (empty($_POST['challengeTimeToDo']) ? '' : ' value="' . $_POST['challengeTimeToDo'] . '"') . '>' .
        '<input type=url name=challengeImage maxlength=255 placeholder="' .
            L('Challenge image URL like http://...') . '"' .
            (empty($_POST['challengeImage']) ? '' : ' value="' . $_POST['challengeImage'] . '"') . '>' .
        '<input type=submit value="' . L('Start a challenge') . '" class=g>');

sendPageToClient(L('Start a challenge'), h1(L('Start a challenge')) . $html);
