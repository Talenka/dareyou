<?php

namespace Dareyou;

require_once 'config.php';

define('PHP_FILE', $_SERVER['SCRIPT_NAME']);
define('NOW', time());
define('HOME', '/');

/**
 * Available languages (keys: 2-letters code, values: vernacular name)
 * @see https://en.wikipedia.org/wiki/ISO_639-1
 * @var array
 */
$definedLanguages = array('en' => 'English', 'fr' => 'Français');

/**
 * @var string English is the default language
 */
$lang = 'en';

/**
 * @return boolean true if the connection uses https protocol, false otherwise.
 */
function isHttps()
{
    return !empty($_SERVER['HTTPS']);
}

/**
 * @param number $n
 * @param number $min
 * @param number $max
 * @return boolean true if $n is betwenn $min and $max included, false otherwise 
 */
function isBetween($n, $min, $max)
{
    return ($n >= $min && $n <= $max);
}

/**
 * Redirect the user to another page via HTTP header with a fallback in HTML/JS
 * @param string $url Where to redirect the user.
 * @param integer $statusCode HTTP status code for the redirection (optionnal).
 */
function redirectTo($url, $statusCode = 200)
{
    $statusCodes = array(
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        500 => '500 Internal Server Error');

    if (isset($statusCodes[$statusCode])) {
        header('Status: ' . $statusCodes[$statusCode], false, $statusCode);
    }

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
    redirectTo('error?' . urlencode($message), 500);
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
    return base_convert(md5($text . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . CRYPT_SALT), 16, 36);
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
 * Check whether the form key sent by user is valid and not expired.
 * @see generateFormKey()
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

    // For debug purpose you could uncomment this line:
    // echo '<!-- ' . $query . ' -->';

    if ($sql === false) displayError($db->error . '<br>' . $query);
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
 * Send an email
 * @param string $to Email recipient
 * @param string $title
 * @param string $message
 * @return boolean
 */
function sendEmail($to, $title = '', $message = '')
{
    if (empty($to)) return false;
    else {
        $title .= ' [' . SITE_TITLE . ']';
        $mailHeaders = 'From: webmaster@' . $_SERVER["SERVER_NAME"] . "\r\n" . 'Content-type: text/html; charset=UTF-8';
        $message = '<!doctype html><html><head><title>' . $title . '</title></head><body>' .
                   '<p style="display:block;margin:0 auto;padding:10% 10px;max-width:600px;height:100%;min-height:600px' .
                       'background:#eee;color:#000;text-align:justify">' . $message . '<br><hr>' .
                       '<small>You are receiving this email because you have registered on our website. You can at ' .
                       'any time delete your account by logging in and modify your profile.</small></p></body></html>';

        if(mail($to, $title, $message, $mailHeaders)) return true;
        else {
            displayError(L('Sending email has failed'));

            return false;
        }
    }
}

/*******************************************************************************
*                                                                              *
*                             HTML CODE GENERATION                             *
*                                                                              *
*******************************************************************************/

/**
 * @param string $html
 * @return string HTML header [h1] tag
 */
function h1($html)
{
    return '<h1>' . $html . '</h1>';
}

/**
 * @param string $html
 * @return string HTML header [h2] tag
 */
function h2($html)
{
    return '<h2>' . $html . '</h2>';
}

/**
 * @param string $html
 * @return string HTML header [h3] tag
 */
function h3($html)
{
    return '<h3>' . $html . '</h3>';
}

/**
 * @param string $html
 * @return string HTML list item [li] tag
 */
function li($html)
{
    return '<li>' . $html . '</li>';
}

/**
 * @param string $href
 * @param string $title
 * @return string HTML link [a] tag
 */
function a($href, $title)
{
    return '<a href=' . $href . '>' . $title . '</a>';
}

/**
 * @param boolean $autofocus
 * @param string $value
 * @return string Html code for the user's name field
 */
function usernameField($autofocus = false, $value = '')
{
    if (empty($value) && !empty($_POST['name'])) $value = $_POST['name'];
    return '<input type=text name=name maxlength=20 pattern="\w{2,25}"' .
            ($autofocus ? ' autofocus' : '') .
            (empty($value) ? '' : ' value="' . $value . '"') .
            ' placeholder="' . L('User name') . '" required' .
            ' title="' . L('Just lowercase letters for your username') . '">';
}

/**
 * @param boolean $autofocus
 * @param string $value
 * @return string Html code for the user's email address field
 */
function usermailField($autofocus = false, $value = '')
{
    if (empty($value) && !empty($_POST['mail'])) $value = $_POST['mail'];
    return '<input type=email name=mail maxlength=255 pattern="[\w@\.]{6,255}"' .
           ($autofocus ? ' autofocus' : '') .
           (empty($value) ? '' : ' value="' . $value . '"') .
           ' placeholder="' . L('Email') . '" required>';
}

/**
 * @return Html code for the user's password field
 */
function userpasswordField()
{
    return '<input type=password name=password maxlength=255 placeholder="' . L('Password') . '" required>';
}

/**
 * @param string $title
 * @param string $params [input] tag attributes (optionnal)
 * @return string Html code for a submit button
 */
function submitButton($title, $params = '')
{
    return '<input type=submit value="' . $title . '"' . (empty($params) ? '' : ' ' . $params) . '>';
}

/**
 * Wraps the html code into a form
 * @param string $url Form destination URL.
 * @param string $html inner html.
 * @return string HTML [form] code.
 */
function form($html, $url = '')
{
    // If no url is specified, we assume the target is the current script
    // Example : PHP_FILE = '/lost-password.php', so $url = 'lost-password'
    if (empty($url)) $url = substr(PHP_FILE, 1, -4);

    return '<form action=' . $url .' method=post>' . $html . generateFormKey() . '</form>';
}

/**
 * Basic form protection against CSRF attack.
 * @param integer $term Form expiration (in seconds from now, optionnal).
 * @return string Html code for the hidden input containing the key.
 */
function generateFormKey($term = 600)
{
    return '<input type=hidden name=formKey value=' .
           base_convert(NOW + $term, 10, 36) . 'O' .
           hashText(NOW + $term) . '>';
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
    return a('profile?' . $name, '<img src="' .
           gravatarUrl($hash, 128) . '" width=128 height=128 align=right>');
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
    return ' ' . a('"' . gravatarProfile($hash) . '" class=b', L('Public profile'));
}

/**
 * @param string $name User canonical name.
 * @param integer $karma User karma quantity.
 * @return string Html link to user profile with user karma as title.
 */
function karmaButton($name, $karma)
{
    return ' ' . a('profile?' . $name . ' class=g', $karma . ' ♣');
}

/**
 * @param string $name User canonical name.
 * @return string Html link to user profile.
 */
function userLink($name)
{
    return a('profile?' . $name, ucfirst($name));
}

/**
 * @param string $name User canonical name.
 * @param string $hash MD5 hash of mail address.
 * @return string Html avatar of user linked to user profile.
 */
function userLinkWithAvatar($name, $hash)
{
    return a('profile?' . $name . ' class=u ' .
           'style="background-image:url(' . gravatarUrl($hash, 20) . ')"', ucfirst($name));
}

/**
 * @return string Html code for language selection.
 */
function languageSelector()
{
    global $definedLanguages, $lang;

    $langs = array();

    foreach ($definedLanguages as $lg => $language) {
        if ($lg != $lang) $langs[] = a('language?' . $lg . ' title=' . L($language), $language);
    }

    return L('In other languages') . ' : ' . implode(', ', $langs);
}

/**
 * Display a challenges list
 * @param boolean $reals Realizations
 * @param string $where
 * @param string $order
 * @param integer $number Challenges number
 * @return string HTML challenges list.
 */
function challengesList($reals = false, $where = '', $order = 'c.created DESC', $number = 5)
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
             ' ' . a('logout class=b', L('Log out')) :
             ((PHP_FILE == '/signup.php') ? '' : a('signup class=g', L('Sign up'))) .
             ((PHP_FILE == '/login.php') ? '' : ' ' . a('login class=t', L('Log in')))
         ),
         '</nav>' . h1(a('.', SITE_TITLE)) . '</header>',
         '<section>' . $html . '</section>';

    exit;
}

/*******************************************************************************
*                                                                              *
*                            MAIN SCRIPT BEGINS HERE                           *
*                                                                              *
*******************************************************************************/

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

    $langs = (empty($_COOKIE['lang'])) ? explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) : array($_COOKIE['lang']);

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
