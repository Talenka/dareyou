<?php

include "config.php";

function isHttps()
{
    return ($_SERVER['HTTPS'] == 'on') ? true : false;
}

function redirectTo($url)
{
    header("Location: " . $url);
    exit;
}

function displayError($message)
{
    error_log($message);
    redirectTo('error');
}

function getSessionCookie()
{
    return (array_key_exists('u', $_COOKIE)) ? $_COOKIE['u'] : '';
}

function sendSessionCookie($sessionId)
{
    return setcookie('u', $sessionId, time()+3600, '/', $_SERVER['SERVER_NAME'], isHttps(), true);
}

function deleteSessionCookie()
{
    return setcookie('u', '', time()-3600, '/', $_SERVER['SERVER_NAME'], isHttps(), true);
}

function hashPassword($password)
{
    return substr(crypt($password.CRYPT_SALT, '$6$'.CRYPT_SALT.'$'), 20);
}

function hashText($text)
{
    return base_convert(md5($text.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].CRYPT_SALT),16,36);
}

function generateSessionId($userId)
{
    return hashText($userId);
}

function cleanUserMail($userMail)
{
    return preg_replace('/[^a-z0-9\.@\-_]/', '', strtolower($userMail));
}

function cleanUserName($userName)
{
    return substr(preg_replace('/[^a-zA-Z0-9]/', '', $userName), 0, 20);
}

function gravatarUrl($hash, $size)
{
    return '//gravatar.com/avatar/'.$hash.'?s='.$size.'&amp;d=wavatar';
}

function getAvatar($name, $hash)
{
    return '<a href=profile?'.$name.'><img src="'.gravatarUrl($hash,128).'" width=128 height=128 align=right></a>';
}

function gravatarProfile($hash)
{
    return '//gravatar.com/'.$hash;
}

function gravatarProfileLink($hash)
{
    return ' <a href="'.gravatarProfile($hash).'" class=btn>Public profile</a>';
}

function karmaButton($name, $karma)
{
    return ' <a href=profile?'.$name.' class="btn green">'.$karma.' ♣</a>';
}

function userLink($name)
{
    return '<a href=profile?'.$name.'>'.ucfirst($name).'</a>';
}

function userLinkWithAvatar($name, $hash)
{
    return '<a href=profile?'.$name.' class=u style="background-image:url('.gravatarUrl($hash,20).')">'.ucfirst($name).'</a>';
}

function publicProfileLink($mailHash)
{
    return ' <a href="'.gravatarProfile($mailHash).'" class=btn>Public profile</a>';
}

function generateFormKey($expire=600)
{
    return '<input type=hidden name=formKey value="'.($expire+time()).'.'.hashText($expire+time()).'">';
}

function isFormKeyValid()
{
    if(empty($_POST['formKey'])) return false;
    else
    {
        list($expire,$hash) = explode('.', $_POST['formKey']);
        return ($expire>time() && hashText($expire) == $hash) ? true : false;
    }
}

function lg($text)
{
    global $sentences;
    return array_key_exists($text, $sentences)?$sentences[$text]:'“'.$text.'”';
}

function challengesList($query, $verb, $karmaColumn, $timeColumn)
{
    global $db;

    $sql  = $db->query($query);
    $code = '';

    while($c = $sql->fetch_object()) $code .= '<li>'
        .'<a href=challenge?'.$c->cid.'>'.utf8_encode($c->title).'</a> '
        .lg($verb).' '.lg('by').' '.userLinkWithAvatar($c->name, $c->mailHash)
        .' : <b>+'.$c->$karmaColumn.' ♣</b> '
        .'<time>('.date(lg('dateFormat'),$c->$timeColumn).')</time></li>';

    return $code;
}

function sendPageToClient($title, $html)
{
    global $client;

    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-cache', true);

    echo '<!doctype html><title>'.SITE_TITLE.' • '.$title.'</title>'
        .'<link rel=stylesheet href=s.css><header><nav>'
        .(isset($client)
            ? userLinkWithAvatar($client->name, $client->mailHash)
             .karmaButton($client->name, $client->karma)
             .' <a href=logout class=btn>'.lg('Log out').'</a>'
            : ' <a href=signup class="btn green">'.lg('Sign up').'</a>'
             .' <a href=login class="btn turquoise">'.lg('Log in').'</a>')
        .'</nav><h1><a href=.>'.SITE_TITLE.'</a></h1></header>'
        .'<section>'.$html.'</section>';
}

$definedLanguages = array('fr' => 'Français', 'en' => 'English');
$lang = 'en';

if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
    $langs = (empty($_COOKIE['lang']))
                ? explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE'])
                : array($_COOKIE['lang']);

    for($i = 0; $i < sizeof($langs); $i++)
    {
        $language = substr($langs[$i], 0, 2);

        if(file_exists('lang.'.$language.'.php'))
        {
            $lang = $language;
            break;
        }
    }
}

include_once 'lang.'.$lang.'.php';

$db   = new mysqli(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DB);
$user = $db->query("SELECT * FROM users WHERE session='".$db->real_escape_string(getSessionCookie())."' LIMIT 1");

if($user->num_rows == 1) $client = $user->fetch_object();

?>