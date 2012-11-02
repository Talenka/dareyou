<?php

include 'core.php';

$loginError = false;

if(isFormKeyValid() && !empty($_POST['mail']) && !empty($_POST['password'])
    && strlen($_POST['mail']) < 256 && strlen($_POST['password']) < 256
    && strlen($_POST['mail']) > 6 && strlen($_POST['password']) > 2
    )
{
    $mailHash = $db->real_escape_string( md5( cleanUserMail($_POST['mail']) ) );
    $password = $db->real_escape_string( hashPassword( $_POST['password'] ) );

    $user = $db->query("SELECT * FROM users WHERE mailHash='".$mailHash."' AND pass='".$password."' LIMIT 1");

    if($user->num_rows == 1)
    {
        $client    = $user->fetch_object();
        $sessionId = generateSessionId($client->id);

        if($db->query("UPDATE users SET session='".$sessionId."' WHERE id=".$client->id." LIMIT 1"))
        {
            sendSessionCookie($sessionId);
            redirectTo('.');
        }
    }
    else $loginError = true;
}

$html = '<form action=login method=post>'
        .'<input type=email name=mail maxlength=255 pattern="[\w@\.]+" autofocus'.(empty($_POST['mail'])? '' : ' value="'.$_POST['mail'].'"').' placeholder="'.lg('Email').'" required>'
        .'<input type=password name=password maxlength=255 placeholder="'.lg('Password').'" required>'
        .'<input type=submit value="'.lg('Log in').'" class="btn turquoise">'
        .generateFormKey()
        .'</form>'
        .'<h3>&nbsp;</h3><a href=lost-password>'.lg('Have you lost your password ?').'</a>';

if($loginError) $html='<div class=warning>'.lg('Email or password is incorrect, please retry').'</div>'.$html;

sendPageToClient(lg('Login'),'<h2>'.lg('Login').'</h2>'.$html);
?>