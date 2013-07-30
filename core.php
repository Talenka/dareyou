<?php

namespace Dareyou;

require_once 'config.php';

define('PHP_FILE', $_SERVER['SCRIPT_NAME']);
define('NOW', time());

$definedLanguages = array('en' => 'English', 'fr' => 'Français');

$lang = 'en'; // English is the default language

/**
 * @return boolean true if the connection uses https protocal, false otherwise.
 */
function isHttps()
{
    return !empty($_SERVER['HTTPS']);
}

/**
 * @param string $url Where to redirect the user.
 */
function redirectTo($url)
{
    echo '<!doctype html><script>window.location="' . $url . '";</script>',
         L('If nothing happen, '),
         '<a href="' . $url . '">' . L('click here to continue') . '</a>';

    exit;
}

/**
 * @param string $message Explanation message (optionnal).
 */
function displayError($message)
{
    redirectTo('error?' . urlencode($message));
}

/**
 * @return string The identification cookie.
 */
function getSessionCookie()
{
    return (array_key_exists('u', $_COOKIE)) ? $_COOKIE['u'] : '';
}

/**
 * @param string $sessionId Session identificator (optionnal).
 * @param int $term Cookie expiration (in seconds from now, optionnal).
 */
function sendSessionCookie($sessionId = '', $term = 3600)
{
    setcookie('u', $sessionId, NOW + $term, '/', $_SERVER['SERVER_NAME'],
              isHttps(), true);
}

function deleteSessionCookie()
{
    sendSessionCookie('', -3600);
}

/**
 * @param string $password
 * @return string
 */
function hashPassword($password)
{
    return substr(crypt($password . CRYPT_SALT, '$6$' . CRYPT_SALT . '$'), 20);
}

/**
 * @param string $text
 * @return string
 */
function hashText($text)
{
    return base_convert(md5($text . $_SERVER['REMOTE_ADDR'] .
                        $_SERVER['HTTP_USER_AGENT'] . CRYPT_SALT), 16, 36);
}

/**
 * @param int $userId
 * @return string
 */
function generateSessionId($userId)
{
    return hashText($userId);
}

/**
 * @param string $userMail
 * @return string
 */
function cleanUserMail($userMail)
{
    return preg_replace('/[^a-z0-9\.@\-_]/', '', strtolower($userMail));
}

/**
 * @param string $userName
 * @return string
 */
function cleanUserName($userName)
{
    return substr(preg_replace('/[^a-zA-Z0-9]/', '', $userName), 0, 20);
}

/**
 * @param string $hash md5 hash of a mail adress (32 chars long).
 * @param integer $size Avatar width & height (in pixels).
 * @return string Gravatar URL.
 */
function gravatarUrl($hash, $size)
{
    return '//gravatar.com/avatar/' . $hash . '?s=' . $size . '&amp;d=wavatar';
}

/**
 * @param string $name User canonical name.
 * @param string $hash MD5 hash of mail address.
 * @return string HTML image of a user avatar linked to user profile.
 */
function getAvatar($name, $hash)
{
    return '<a href=profile?' . $name . '><img src="' .
           gravatarUrl($hash, 128) . '" width=128 height=128 align=right></a>';
}

/**
 * @param string $hash MD5 hash of mail address.
 * @return Gravatar profile URL.
 */
function gravatarProfile($hash)
{
    return '//gravatar.com/' . $hash;
}

/**
 * @param string $hash MD5 hash of mail address.
 * @return Gravatar profile link.
 */
function gravatarProfileLink($hash)
{
    return ' <a href="' . gravatarProfile($hash) .
           '" class=b>' . L('Public profile') . '</a>';
}

/**
 * @param string $name User canonical name.
 * @param integer $karma User karma quantity.
 * @return string Html link to user profile with user karma as title.
 */
function karmaButton($name, $karma)
{
    return ' <a href=profile?' . $name . ' class=g>' . $karma . ' ♣</a>';
}

/**
 * @param string $name User canonical name.
 * @return string Html link to user profile.
 */
function userLink($name)
{
    return '<a href=profile?' . $name . '>' . ucfirst($name) . '</a>';
}

/**
 * @param string $name User canonical name.
 * @param string $hash MD5 hash of mail address.
 * @return string Html avatar of user linked to user profile.
 */
function userLinkWithAvatar($name, $hash)
{
    return '<a href=profile?' . $name . ' class=u ' .
           'style="background-image:url(' . gravatarUrl($hash, 20) . ')">' .
           ucfirst($name) . '</a>';
}

/**
 * @param integer $term Form expiration (in seconds from now, optionnal).
 * @return string Html code for the hidden input containing the key.
 */
function generateFormKey($term = 600)
{
    return '<input type=hidden name=formKey value=' .
           base_convert($term + NOW, 10, 36) . 'O' .
           hashText($term + NOW) . '>';
}

/**
 * Check whether the form key sent by user is valid and not expired.
 * @return boolean
 */
function isFormKeyValid()
{
    if (empty($_POST['formKey'])) return false;
    else {

        list($expire, $hash) = explode('O', $_POST['formKey']);

        $expire = base_convert($expire, 36, 10);

        return ($expire > NOW && hashText($expire) == $hash);
    }
}

/**
 * @param Object $user
 * @return boolean True if $user is the admin, false otherwise.
 */
function isAdmin($user)
{
    return (ADMIN_HASH == $user->mailHash);
}

/**
 * Translate the text in the user language, or returns the text if it fails.
 * @param string $text
 * @return string
 */
function L($text)
{
    global $sentences;

    return array_key_exists($text, $sentences) ? $sentences[$text] : $text;
}

/**
 * @param boolean $reals
 * @param string $where
 * @param string $order
 * @param integer $number
 * @return string
 */
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

        $code .= li('<a href="challenge?' . urlencode($c->title) . '">' .
                 utf8_encode($c->title) . '</a> ' . $verb . ' ' . L('by') .
                 ' ' . userLinkWithAvatar($c->name, $c->mailHash) .
                 ' : <b>+' . $c->$karmaColumn . ' ♣</b> <time>' .
                 '(' . date(L('dateFormat'), $c->$timeColumn) . ')</time>');
    }

    return $code . '</ul>';

}

/**
 * @param string $sessionId
 */
function identifyClient($sessionId = '')
{
    global $client, $db;

    if (empty($sessionId)) $sessionId = getSessionCookie();

    $sessId = generateSessionId($db->real_escape_string($sessionId));

    $user = select('users', '*', "session='" . $sessId . "'", 1);

    if ($user->num_rows == 1) $client = $user->fetch_object();
}

/**
 * Responds to the user request with an HTML page.
 * @param string $title Page title (in the header [title] tag).
 * @param string $html Html code of the page [body] tag.
 */
function sendPageToClient($title, $html)
{
    global $client, $db;

    if (isset($db)) $db->close();

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
         '</nav>' . h1('<a href=.>' . SITE_TITLE . '</a>') . '</header>',
         '<section>' . $html . '</section>';

    exit;
}

/**
 * @param string $table SQL table name.
 * @param string $cols List of columns to return (all by default).
 * @param string $where Conditionnal filter.
 * @param string $limit Maximum number of result returned (or a range).
 * @param string $order "ASC"ending or "DESC"ending order
 * @return Object SQL ressource
 */
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

/**
 * Count items from an SQL table with optionnal filter
 * @param string $table SQL Table name.
 * @param string $where Optionnal conditionnal filter.
 * @return int Number of row in the table satisfying the WHERE condition.
 */
function selectCount($table, $where = '')
{
    return select($table, 'COUNT(*) as n', $where)->fetch_object()->n;
}


/**
 * @return string Html code for language selection.
 */
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


/**
 * @param string $html
 * @return string
 */
function h1($html)
{
    return '<h1>' . $html . '</h1>';
}


/**
 * @param string $html
 * @return string
 */
function h2($html)
{
    return '<h2>' . $html . '</h2>';
}


/**
 * @param string $html
 * @return string
 */
function h3($html)
{
    return '<h3>' . $html . '</h3>';
}

/**
 * @param string $html
 * @return string
 */
function li($html)
{
    return '<li>' . $html . '</li>';
}

/**
 * @param string $href
 * @param string $title
 * @return string
 */
function a($href, $title)
{
    return '<a href=' . $href . '>' . $title . '</a>';
}

/**************************
* Main script begins here *
**************************/

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

// Include the current user language file.
include_once 'lang.'. $lang . '.php';

// If this is not an error page, we connect to the database.
if (PHP_FILE != '/error.php') {

    $db = new \mysqli(SQL_HOST, SQL_USER, SQL_PASSWORD, SQL_DB);

    if ($db->connect_errno) displayError('Unable to access database !');
    elseif (getSessionCookie() != '') identifyClient();
}
