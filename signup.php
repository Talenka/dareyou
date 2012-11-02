<?php
include 'core.php';

$signupError = array();

if(isFormKeyValid() && !empty($_POST['name']) && !empty($_POST['mail'])
    && strlen($_POST['mail']) < 256 && strlen($_POST['password']) < 256 && strlen($_POST['name']) < 256
    && strlen($_POST['mail']) > 6 && strlen($_POST['password']) > 2 && strlen($_POST['name']) > 2 
    && !empty($_POST['password']) && !empty($_POST['password2']))
{
    if($_POST['password'] != $_POST['password2']) $signupError[] = lg('Password and its confirmation does not match');
    else 
    {
        $name = $db->real_escape_string(cleanUserName($_POST['name']));
        $mailHash = md5($db->real_escape_string(cleanUserMail($_POST['mail'])));
        $pass = $db->real_escape_string(hashPassword($_POST['password']));

        $user = $db->query("SELECT * FROM users WHERE name='".$name."'");
        if($user->num_rows > 0) $signupError[] = lg('This name is already used by another user');

        $user = $db->query("SELECT * FROM users WHERE mailHash='".$mailHash."'");
        if($user->num_rows > 0) $signupError[] = lg('This email is already used by another user');

        if(sizeof($signupError) == 0)
        {
            if($db->query("INSERT INTO users (name,mailHash,pass,session,karma) VALUES ('".$name."','".$mailHash."','".$pass."','',20)"))
            {
                $newId     = $db->insert_id;
                $sessionId = generateSessionId($newId);

                if($db->query("UPDATE users SET session='".$sessionId."' WHERE id=".$newId." LIMIT 1"))
                {
                    sendSessionCookie($sessionId);
                    redirectTo('.');
                }
            }
        }
    }
}

$html = ((sizeof($signupError) > 0)?'<p class=warning>'.implode('. ',$signupError).'</p>' : '')
        .'<form action=signup method=post>'
        .'<input type=text name=name maxlength=20 pattern="[a-zA-Z]{2,25}"'.(empty($_POST['name'])? '' : ' value="'.$_POST['name'].'"').' placeholder="'.lg('User name').'" required autofocus title="'.lg('JUSTLOWERCASE').'">'
        .'<input type=email name=mail maxlength=255'.(empty($_POST['mail'])? '' : ' value="'.$_POST['mail'].'"').' placeholder="'.lg('Email').'" required>'
        .'<input type=password name=password maxlength=255 placeholder="'.lg('Password').'" required>'
        .'<input type=password name=password2 maxlength=255 placeholder="'.lg('CONFIRMPASSWORD').'" required>'
        .'<input type=submit value="'.lg('Sign up').'" class="btn green">'
        .generateFormKey()
        .'<h3>&nbsp;</h3>'
        .'<ul>'
        .'<li>'.lg('You will start with 20 karma points, you may bet with it').'</li>'
        .'<li>'.lg('Just lowercase letters for your username').'</li>'
        .'<li>'.lg('Your email will stay confidential, no jokes').'</li>'
        .'<li>'.lg('Choose a long and unique password').'</li>'
        .'<li>'.lg('We use Gravatar as your icon').'</li>'
        .'</ul>'
        .'</form>';

sendPageToClient(lg('Signup'),'<h2>'.lg('Signup').'</h2>'.$html);
?>