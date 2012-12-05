<?php
include_once 'core.php';

if(isFormKeyValid())
{
    $warnings = array();

    if(empty($_POST['challengeTitle'])) $warnings[] = lg('You have not given a challenge title');
    else if(strlen($_POST['challengeTitle']) < 3) $warnings[] = lg('Your title is too short (3 letters minimum)');
    else if(strlen($_POST['challengeTitle']) > 255) $warnings[] = lg('Your title is too long (255 letters maximum)');

    if(strlen($_POST['challengeDescription']) > 65535) $warnings[] = lg('Your description is too long (65535 letters maximum)');

    if($_POST['challengeTimeToDo'] < 1) $warnings[] = lg('It takes at least 1 day to complete the challenge');

    if(strlen($_POST['challengeImage']) > 255) $warnings[] = lg('Your image URL is too long (255 characters maximum)');
}


$html = '<form action=start-challenge method=POST>'
        .(empty($warnings)?'':'<div class=warning>'.lg('There are some errors that prevent starting the challenge:').'<br>'.implode('<br>', $warnings).'</div>')
        .'<input type=text name=challengeTitle maxlength=255 placeholder="'.lg('The challenge title (simple and unique)').'" autofocus>'
        .'<textarea name=challengeDescription maxlength=65535 placeholder="'.lg('Challenge description with details').'" rows=5></textarea>'
        .'<input type=number name=challengeTimeToDo maxlength=3 min=1 max=365 placeholder="'.lg('Time to accomplish the challenge (in days)').'">'
        .'<input type=url name=challengeImage maxlength=255 placeholder="'.lg('Challenge image URL like http://...').'">'
        .'<input type=submit value="'.lg('Start a challenge').'" class="btn green">'
        .generateFormKey()
        .'</form>';

sendPageToClient(lg('Start a challenge'),
                '<h1>'.lg('Start a challenge').'</h1>'.$html);
?>