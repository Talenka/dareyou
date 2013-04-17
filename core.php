<?php

namespace Dareyou;

require_once 'config.php';

define('PHP_FILE', $_SERVER['SCRIPT_NAME']);
define('NOW', time());

$definedLanguages = array('en' => 'English', 'fr' => 'Français');

$lang = 'en'; // English is the default language

function isHttps()
{
    return !empty($_SERVER['HTTPS']);
}

function redirectTo($url)
{
    echo '<!doctype html><script>window.location="' . $url . '";</script>',
         L('If nothing happen, '),
         '<a href="' . $url . '">' . L('click here to continue') . '</a>';

    exit;
}

function displayError($message)
{
    redirectTo('error?' . urlencode($message));
}

function getSessionCookie()
{
    return (array_key_exists('u', $_COOKIE)) ? $_COOKIE['u'] : '';
}

function sendSessionCookie($sessionId = '', $term = 3600)
{
    setcookie('u', $sessionId, NOW + $term, '/', $_SERVER['SERVER_NAME'],
              isHttps(), true);
}

function deleteSessionCookie()
{
    sendSessionCookie('', -3600);
}

function hashPassword($password)
{
    return substr(crypt($password . CRYPT_SALT, '$6$' . CRYPT_SALT . '$'), 20);
}

function hashText($text)
{
    return base_convert(md5($text . $_SERVER['REMOTE_ADDR'] .
                        $_SERVER['HTTP_USER_AGENT'] . CRYPT_SALT), 16, 36);
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
    return '//gravatar.com/avatar/' . $hash . '?s=' . $size . '&amp;d=wavatar';
}

function getAvatar($name, $hash)
{
    return '<a href=profile?' . $name . '><img src="' .
           gravatarUrl($hash, 128) . '" width=128 height=128 align=right></a>';
}

function gravatarProfile($hash)
{
    return '//gravatar.com/' . $hash;
}

function gravatarProfileLink($hash)
{
    return ' <a href="' . gravatarProfile($hash) .
           '" class=b>' . L('Public profile') . '</a>';
}

function karmaButton($name, $karma)
{
    return ' <a href=profile?' . $name . ' class=g>' . $karma . ' ♣</a>';
}

function userLink($name)
{
    return '<a href=profile?' . $name . '>' . ucfirst($name) . '</a>';
}

function userLinkWithAvatar($name, $hash)
{
    return '<a href=profile?' . $name . ' class=u ' .
           'style="background-image:url(' . gravatarUrl($hash, 20) . ')">' .
           ucfirst($name) . '</a>';
}

function generateFormKey($term = 600)
{
    return '<input type=hidden name=formKey value=' .
           base_convert($term + NOW, 10, 36) . 'O' .
           hashText($term + NOW) . '>';
}

function isFormKeyValid()
{
    if (empty($_POST['formKey'])) return false;
    else {

        list($expire, $hash) = explode('O', $_POST['formKey']);

        $expire = base_convert($expire, 36, 10);

        return ($expire > NOW && hashText($expire) == $hash);
    }
}

function isAdmin($user)
{
    return (ADMIN_HASH == $user->mailHash);
}

function L($text)
{
    global $sentences;
    return array_key_exists($text, $sentences) ? $sentences[$text] : $text;
}

function challengesList($reals = false,
                         $where = '',
                         $order = 'c.created DESC',
                         $number = 5)
{
    global $db;

    $timeColumn  = $reals ? 'end' : 'created';
    $karmaColumn = $reals ? 'value' : 'totalSum';
    $verb = L($reals ? 'won' : 'issued');

    $sql = select('users u,challenges c' . ($reals ? ',realizations r' : ''),
                  'u.name,u.mailHash,c.title,c.cid,' .
                      ($reals ? 'r.value,r.end' : 'c.totalSum,c.created'),
                  (empty($where) ? '' : $where . ' AND ') .
                  ($reals ? 'r.cid=c.cid AND r.uid=u.id' : 'c.author=u.id'),
                  $number, $order);

    $code = '<ul>';

    while ($c = $sql->fetch_object()) {

        $code .= '<li><a href="challenge?' . urlencode($c->title) . '">' .
                 utf8_encode($c->title) . '</a> ' . $verb . ' ' . L('by') .
                 ' ' . userLinkWithAvatar($c->name, $c->mailHash) .
                 ' : <b>+' . $c->$karmaColumn . ' ♣</b> <time>' .
                 '(' . date(L('dateFormat'), $c->$timeColumn) . ')</time></li>';
    }

    return $code . '</ul>';

}

function identifyClient($sessionId = '')
{
    global $client, $db;

    if (empty($sessionId)) $sessionId = getSessionCookie();

    $sessId = generateSessionId($db->real_escape_string($sessionId));

    $user = select('users', '*', "session='" . $sessId . "'", 1);

    if ($user->num_rows == 1) $client = $user->fetch_object();
}

function sendPageToClient($title, $html)
{
    global $client, $db;

    if(isset($db)) $db->close();

    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-cache', true);
    header('Expires: ' . date('r'));

    echo '<!doctype html><title>' . $title . ' - ' . SITE_TITLE . '</title>',
         '<link rel=stylesheet href=s.css><header><nav>',
         (isset($client) ?
             userLinkWithAvatar($client->name, $client->mailHash) .
             karmaButton($client->name, $client->karma) .
             ' <a href=logout class=b>' . L('Log out') . '</a>' :
             ((PHP_FILE == '/signup.php') ? '' :
                ' <a href=signup class=g>' . L('Sign up') . '</a>') .
             ((PHP_FILE == '/login.php') ? '' :
                ' <a href=login class=t>' . L('Log in') . '</a>')
         ),
         '</nav><h1><a href=.>' . SITE_TITLE . '</a></h1></header>',
         '<section>' . $html . '</section>';

    exit;
}

function select($table, $cols = '*', $where = '', $limit = '', $order = '')
{
    global $db;

    $query = 'SELECT ' . $cols . ' FROM ' . $table .
             (empty($where) ? '' : ' WHERE ' . $where) .
             (empty($order) ? '' : ' ORDER BY ' . $order) .
             (empty($limit) ? '' : ' LIMIT ' . $limit);

    $sql = $db->query($query);

    // echo '<!-- ' . $query . ' -->';

    if($sql === false) displayError($db->error . '<br>' . $query);
    else return $sql;
}

function selectCount($table, $where = '')
{
    return select($table, 'COUNT(*) as n', $where)->fetch_object()->n;
}

function languageSelector()
{
    global $definedLanguages, $lang;

    $langs = array();

    foreach ($definedLanguages as $lg => $language) {
        if ($lg != $lang) {
            $langs[] = '<a href=language?' . $lg .
                       ' title=' . L($language) . '>' . $language . '</a>';
        }
    }

    return L('In other languages') . ' : ' . implode(', ', $langs);
}

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

    $langs = (empty($_COOKIE['lang'])) ?
                 explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) :
                 array($_COOKIE['lang']);

    for ($i = 0, $j = sizeof($langs); $i < $j; $i++) {

        $language = substr($langs[$i], 0, 2);

        if (file_exists('lang.' . $language . '.php')) {

            $lang = $language;
            break;
        }
    }
}

function h1($html)
{
    return '<h1>' . $html . '</h1>';
}

function h2($html)
{
    return '<h2>' . $html . '</h2>';
}

function a($href, $title)
{
    return '<a href=' . $href . '>' . $title . '</a>';
}

include_once 'lang.' . $lang . '.php';

if (PHP_FILE != '/error.php') {

    $db = new \mysqli(SQL_HOST, SQL_USER, SQL_PASSWORD, SQL_DB);

    if ($db->connect_errno) displayError('Unable to access database !');
    elseif (getSessionCookie() != '') identifyClient();
}
