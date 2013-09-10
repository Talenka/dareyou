<?php
/**
 * This script is the core of this website, and therefore must be included in
 * all other scripts.
 */

namespace Dareyou;

if (!file_exists('config.php'))
    die('Error: there is no config.php file, try to edit config.sample.php');

require_once 'config.php';

/*******************************************************************************
*                                                                              *
*                              GENERAL DEFINITIONS                             *
*                                                                              *
*******************************************************************************/

define('PHP_FILE', $_SERVER['SCRIPT_NAME']);
define('NOW', time());

const HOME     = '/';
const ONE_HOUR =  3600;
const ONE_DAY  = 86400;

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
 * @var array List of common passwords, which are forbidden on this website
 */
$commonPasswords = array('123456','porsche','firebird','prince','rosebud',
    'password','guitar','butter','beach','jaguar','12345678','chelsea','united',
    'amateur','great','1234','black','turtle','7777777','cool','pussy',
    'diamond','steelers','muffin','cooper','12345','nascar','tiffany','redsox',
    '1313','dragon','jackson','zxcvbn','star','scorpio','qwerty','cameron',
    'tomcat','testing','mountain','696969','654321','golf','shannon','madison',
    'mustang','computer','bond007','murphy','987654','letmein','amanda','bear',
    'frank','brazil','baseball','wizard','tiger','hannah','lauren','master',
    'xxxxxxxx','doctor','dave','japan','michael','money','gateway','eagle1',
    'naked','football','phoenix','gators','11111','squirt','shadow','mickey',
    'angel','mother','stars','monkey','bailey','junior','nathan','apple',
    'abc123','knight','thx1138','raiders','alexis','pass','iceman','porno',
    'steve','aaaa','fuckme','tigers','badboy','forever','bonnie','6969',
    'purple','debbie','angela','peaches','jordan','andrea','spider','viper',
    'jasmine','harley','horny','melissa','ou812','kevin','ranger','dakota',
    'booger','jake','matt','iwantu','aaaaaa','1212','lovers','qwertyui',
    'jennifer','player','flyers','suckit','danielle','hunter','sunshine','fish',
    'gregory','beaver','fuck','morgan','porn','buddy','4321','2000','starwars',
    'matrix','whatever','4128','test','boomer','teens','young','runner',
    'batman','cowboys','scooby','nicholas','swimming','trustno1','edward',
    'jason','lucky','dolphin','thomas','charles','walter','helpme','gordon',
    'tigger','girls','cumshot','jackie','casper','robert','booboo','boston',
    'monica','stupid','access','coffee','braves','midnight','shit','love',
    'xxxxxx','yankee','college','saturn','buster','bulldog','lover','baby',
    'gemini','1234567','ncc1701','barney','cunt','apples','soccer','rabbit',
    'victor','brian','august','hockey','peanut','tucker','mark','3333','killer',
    'john','princess','startrek','canada','george','johnny','mercedes','sierra',
    'blazer','sexy','gandalf','5150','leather','cumming','andrew','spanky',
    'doggie','232323','hunting','charlie','winter','zzzzzz','4444','kitty',
    'superman','brandy','gunner','beavis','rainbow','asshole','compaq','horney',
    'bigcock','112233','fuckyou','carlos','bubba','happy','arthur','dallas',
    'tennis','2112','sophie','cream','jessica','james','fred','ladies','calvin',
    'panties','mike','johnson','naughty','shaved','pepper','brandon','xxxxx',
    'giants','surfer','1111','fender','tits','booty','samson','austin',
    'anthony','member','blonde','kelly','william','blowme','boobs','fucked',
    'paul','daniel','ferrari','donald','golden','mine','golfer','cookie',
    'bigdaddy','0','king','summer','chicken','bronco','fire','racing','heather',
    'maverick','penis','sandra','5555','hammer','chicago','voyager','pookie',
    'eagle','yankees','joseph','rangers','packers','hentai','joshua','diablo',
    'birdie','einstein','newyork','maggie','sexsex','trouble','dolphins',
    'little','biteme','hardcore','white','0','redwings','enter','666666',
    'topgun','chevy','smith','ashley','willie','bigtits','winston','sticky',
    'thunder','welcome','bitches','warrior','cocacola','cowboy','chris','green',
    'sammy','animal','silver','panther','super','slut','broncos','richard',
    'yamaha','qazwsx','8675309','private','fucker','justin','magic','zxcvbnm',
    'skippy','orange','banana','lakers','nipples','marvin','merlin','driver',
    'rachel','power','blondes','michelle','marine','slayer','victoria','enjoy',
    'corvette','angels','scott','asdfgh','girl','bigdog','fishing','2222',
    'vagina','apollo','cheese','david','asdf','toyota','parker','matthew',
    'maddog','video','travis','qwert','121212','hooters','london','hotdog',
    'time','patrick','wilson','7777','paris','sydney','martin','butthead',
    'marlboro','rock','women','freedom','dennis','srinivas','xxxx','voodoo',
    'ginger','fucking','internet','extreme','magnum','blowjob','captain',
    'action','redskins','juice','nicole','bigdick','carter','erotic','abgrtyu',
    'sparky','chester','jasper','dirty','777777','yellow','smokey','monster',
    'ford','dreams','camaro','xavier','teresa','freddy','maxwell','secret',
    'steven','jeremy','arsenal','music','dick','viking','11111111','access14',
    'rush2112','falcon','snoopy','bill','wolf','russia','taylor','blue',
    'crystal','nipple','scorpion','111111','eagles','peter','iloveyou',
    'rebecca','131313','winner','pussies','alex','tester','123123','samantha',
    'cock','florida','mistress','bitch','house','beer','eric','phantom','hello',
    'miller','rocket','legend','billy','scooter','flower','theman','movie',
    '6666','0','please','jack','oliver','success','albert','azerty','azerazer',
    'rezareza','ninja','jesus','cheval');

/**
 * @var string List of forbidden user names (for security of confusion reason)
 */
$forbiddenNames = array('login', 'null', 'true', 'false', 'anonymous', 'exit',
    'root', 'admin', 'administrator', 'moderator', 'mail', 'mysql', 'sql',
    'undefined', 'dareyou', 'google', 'facebook', 'test', 'class', 'function',
    'delete', 'insert', 'update', 'www', 'referee', 'yes', 'logout', 'signup',
    'challenge', 'karma', 'index', 'home', 'config', 'winner', 'yes');

/*******************************************************************************
*                                                                              *
*                               GENERAL FUNCTIONS                              *
*                                                                              *
*******************************************************************************/

/**
 * Is the connection using https protocol ?
 * @return boolean true if https, false otherwise.
 */
function isHttps()
{
    return !empty($_SERVER['HTTPS']);
}

/**
 * Is a number in an interval ?
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
        301 => '301 Moved Permanently',
        307 => '307 Temporary Redirect',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        429 => '429 Too Many Requests',
        500 => '500 Internal Server Error');

    if (isset($statusCodes[$statusCode])) {
        header('Status: ' . $statusCodes[$statusCode], false, $statusCode);
    }

    if ($statusCode == 301) {
        header('Location: ' . $url, false);
    } else echo '<!doctype html><script>window.location="' . $url . '";</script>',
              L('If nothing happen, '),
              '<a href="' . $url . '">' . L('click here to continue') . '</a>';

    exit;
}

/**
 * If user is not logged, then we redirect him to homepage.
 */
function restrictAccessToLoggedInUser()
{
    global $client;

    if (empty($client)) redirectTo(HOME, 403);
}

/**
 * If user is not logged in or if he is not administrator,
 * then we redirect him to homepage.
 */
function restrictAccessToAdministrator()
{
    global $client;

    if (!isAdmin($client)) redirectTo(HOME, 403);
}

/**
 * Redirect to an error page
 * @param string $message Explanation message (optionnal).
 */
function displayError($message = '')
{
    redirectTo('error?' . urlencode($message), 500);
}

/**
 * Get identification cookie
 * @return string The ID cookie.
 */
function getSessionCookie()
{
    return (array_key_exists('u', $_COOKIE)) ? $_COOKIE['u'] : '';
}

/**
 * Set identification cookie
 * @param string $sessionId Session identificator (optionnal).
 * @param int $term Cookie expiration (in seconds from now, optionnal).
 */
function sendSessionCookie($sessionId = '', $term = ONE_HOUR)
{
    setcookie('u', $sessionId, NOW + $term, '/', $_SERVER['SERVER_NAME'],
              isHttps(), true);
}

/**
 * Delete user identification cookie
 */
function deleteSessionCookie()
{
    sendSessionCookie('', -1 * ONE_DAY);
}

/**
 * Hash user's password properly before it's stored in the database
 * @param string $password
 * @return string
 * @todo use blowfish to improve drastically hash robustness
 */
function hashPassword($password)
{
    // if (CRYPT_BLOWFISH == 1) crypt('rasmuslerdorf', '$2y$31$wB4M88d5UcOD71FhnY3Yxs$');
    return substr(crypt($password . CRYPT_SALT, '$6$' . CRYPT_SALT . '$'), 20);
}

/**
 * Return ephemeral md5 hash of a text.
 *
 * Ephemeral means here that the hash expires when the current user IP or
 * browser changes.
 *
 * @param string $text
 * @return string
 */
function hashText($text)
{
    return base_convert(md5($text . $_SERVER['REMOTE_ADDR'] .
                            $_SERVER['HTTP_USER_AGENT'] . CRYPT_SALT), 16, 36);
}

/**
 * Generates user's session identifier
 * @param int $userId
 * @return string
 */
function generateSessionId($userId)
{
    return hashText($userId);
}

/**
 * Sanitize a little bit a user mail input
 * @param string $userMail
 * @return string
 */
function cleanUserMail($userMail)
{
    return preg_replace('/[^a-z0-9\.@\-_]/', '', strtolower($userMail));
}

/**
 * Sanitize a little bit a user name input
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

        return ($expire > NOW && hashText($expire) === $hash);
    }
}

/**
 * Is the current user the website admin ?
 * @param Object $user
 * @return boolean True if $user is the admin, false otherwise.
 */
function isAdmin($user)
{
    return (!empty($user) && ADMIN_HASH == $user->mailHash);
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
 * Try to associates the session ID to an logged user.
 * @param string $sessionId
 */
function identifyClient($sessionId = '')
{
    global $client, $db;

    if (empty($sessionId)) $sessionId = getSessionCookie();

    $sessId = generateSessionId($db->real_escape_string($sessionId));

    $user = select('users', '*', "session='" . $sessId . "'", 1);

    if ($user->num_rows == 1) $client = $user->fetch_object();

    $user->free();
}

/**
 * Execute a SQL selection query
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
 * Execute a SQL count query
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

        $mailHeaders = 'From: webmaster@' . $_SERVER["SERVER_NAME"] . "\r\n" .
                       'Content-type: text/html; charset=UTF-8';

        $message = '<!doctype html><html>' .
                   '<head><title>' . $title . '</title></head>' .
                   '<body>' .
                   '<p style="display:block;margin:0 auto;padding:10% 10px;' .
                       'max-width:600px;height:100%;min-height:600px;' .
                       'background:#eee;color:#000;text-align:justify">' .
                       $message . '<br><hr>' .
                       '<small>You are receiving this email because you have ' .
                       'registered on our website. You can at any time delete ' .
                       'your account by logging in and modify your profile.' .
                       '</small></p>' .
                   '</body></html>';

        if(mail($to, $title, $message, $mailHeaders)) return true;
        else {
            displayError(L('Sending email has failed'));

            return false;
        }
    }
}

/**
 * Write a user activity in the log
 * @param string $text
 * @param string $url
 * @param boolean $public
 */
function logActivity($text, $url = '', $public = false)
{
    global $db, $client;

    if (empty($url)) $url = PHP_FILE;

    $db->query('INSERT INTO `logs` (`date`,`user`,`text`,`public`,`url`) VALUES(' . NOW . ',' .
               (empty($client) ? 0 : $client->id) . ',' .
               '"' . $db->real_escape_string($text) . '",' .
               (($public === true) ? 1 : 0) . ',' .
               '"' . $db->real_escape_string($url) . '")');
}

/*******************************************************************************
*                                                                              *
*                             HTML CODE GENERATION                             *
*                                                                              *
*******************************************************************************/

/**
 * Return a HTML header [h1] tag
 * @param string $html
 * @return string
 */
function h1($html)
{
    return '<h1>' . $html . '</h1>';
}

/**
 * Return a HTML header [h2] tag
 * @param string $html
 * @return string
 */
function h2($html)
{
    return '<h2>' . $html . '</h2>';
}

/**
 * Return a HTML header [h3] tag
 * @param string $html
 * @return string
 */
function h3($html)
{
    return '<h3>' . $html . '</h3>';
}

/**
 * Return a HTML list [li] tag
 * @param string $html
 * @return string
 */
function li($html)
{
    return '<li>' . $html . '</li>';
}

/**
 * Return a HTML link [a] tag
 * @param string $href
 * @param string $title
 * @return string
 */
function a($href, $title)
{
    return '<a href=' . $href . '>' . $title . '</a>';
}

/**
 * Return a HTML [input] field for a user name
 * @param boolean $autofocus
 * @param string $value
 * @todo UTF8 validation ?
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
 * Return a HTML [input] field for a user mail
 * @param boolean $autofocus
 * @param string $value
 * @todo UTF8 validation ?
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
 * Return a HTML [input] field for a user password
 * @return Html code for the user's password field
 */
function userpasswordField()
{
    return '<input type=password name=password maxlength=255 placeholder="' . L('Password') . '" required>';
}

/**
 * Return a HTML [input] button to submit a form
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
 *
 * If no url is specified, we assume the target is the current script
 * Example : PHP_FILE = '/lost-password.php', so $url = 'lost-password'
 *
 * @param string $url Form destination URL.
 * @param string $html inner html.
 * @return string HTML [form] code.
 */
function form($html, $url = '')
{
    if (empty($url)) $url = substr(PHP_FILE, 1, -4);
    return '<form action=' . $url .' method=post>' .
               $html . generateFormKey() .
           '</form>';
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
 * Gravatar url
 * @param string $hash md5 hash of a mail adress (32 chars long).
 * @param integer $size Avatar width & height (in pixels).
 * @return string Gravatar URL.
 */
function gravatarUrl($hash, $size = 20)
{
    return '//gravatar.com/avatar/' . $hash . '?s=' . $size . '&amp;d=wavatar';
}

/**
 * User gravatar linked to his profile
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
 * Gravatar public profile url
 * @param string $hash MD5 hash of mail address.
 * @return Gravatar profile URL.
 */
function gravatarProfile($hash)
{
    return '//gravatar.com/' . $hash;
}

/**
 * Link to the gravatar public profile.
 * @param string $hash MD5 hash of mail address.
 * @return Gravatar profile link.
 */
function gravatarProfileLink($hash)
{
    return ' ' . a('"' . gravatarProfile($hash) . '" class=b', L('Public profile'));
}

/**
 * HTML code for the karma counter of a user
 * @param string $name User canonical name.
 * @param integer $karma User karma quantity.
 * @return string Html link to user profile with user karma as title.
 */
function karmaButton($name, $karma)
{
    return ' ' . a('profile?' . $name . ' class=g', $karma . ' ♣');
}

/**
 * Link to a user profile
 * @param string $name User canonical name.
 * @return string Html link to user profile.
 */
function userLink($name)
{
    return a('profile?' . $name, ucfirst($name));
}

/**
 * Link to a user profile with a small gravatar
 * @param string $name User canonical name.
 * @param string $hash MD5 hash of mail address.
 * @param string $params Optionnal attributes for the [a] tag.
 * @return string Html avatar of user linked to user profile.
 */
function userLinkWithAvatar($name, $hash, $params = '')
{
    return a('profile?' . $name . ' class=u' . $params .
             ' style="background-image:url(' . gravatarUrl($hash, 20) . ')"',
             ucfirst($name));
}

/**
 * HTML code for language selection (for example in the homepage)
 * @return string Html code for language selection.
 */
function languageSelector()
{
    global $definedLanguages, $lang;

    $langs = array();

    foreach ($definedLanguages as $lg => $language)
        if ($lg != $lang) $langs[] = a('language?' . $lg . ' title=' . L($language), $language);
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

    while ($c = $sql->fetch_object())

        $code .= li('<a href="challenge?' . urlencode($c->title) . '">' .
                 utf8_encode($c->title) . '</a> ' . $verb . ' ' . L('by') .
                 ' ' . userLinkWithAvatar($c->name, $c->mailHash) .
                 ' : <b>+' . $c->$karmaColumn . ' ♣</b> <time>' .
                 '(' . date(L('dateFormat'), $c->$timeColumn) . ')</time>');

    $sql->free();

    return $code . '</ul>';
}

/**
 * Responds to the user request with a HTML page.
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

    echo '<!doctype html>' .
         '<title>' . $title . ' - ' . SITE_TITLE . '</title>',
         '<link rel=stylesheet href=s.css>' .
         '<header><nav>',
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
*                               HTML CODE CACHING                              *
*                                                                              *
*******************************************************************************/

/**
 * Returns the cache file path
 * @param string $id Content identifier
 * @return string
 */
function cacheFilePath($id)
{
    global $lang;

    return 'cache' . PHP_FILE . '_' . $lang . '_' . $id . '.htm';
}

/**
 * Caches content in a static file (in the /cache/ directory)
 * @param string $id Content identifier
 * @param string $content Something to cache
 * @return string The content
 */
function cache($id, $content = '')
{
    file_put_contents(cacheFilePath($id), $content);

    return $content; 
}

/**
 * Retrieves content from
 * @param string $id Content identifier
 * @param integer $term content expiration (in seconds)
 * @return string|false The cached content (or false if there is no cache)
 */
function getFromCache($id, $term = 300)
{
    $cFile = cacheFilePath($id);

    return (!file_exists($cFile) || filemtime($cFile) < NOW - $term) ? false : file_get_contents($cFile);
}

/*******************************************************************************
*                                                                              *
*                            MAIN SCRIPT BEGINS HERE                           *
*                                                                              *
*******************************************************************************/

// If we are not on the canonical server, we redirect user to him:
if ($_SERVER['SERVER_NAME'] != SERVER_NAME)
    redirectTo('http://' . SERVER_NAME .
               ((PHP_FILE == '/index.php') ? '/' : PHP_FILE) .
               (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']), 301);

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

    $langs = (empty($_COOKIE['lang'])) ? explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) :
                                         array($_COOKIE['lang']);

    $i = 0;

    $j = sizeof($langs);

    while ($i < $j) {

        $language = substr($langs[$i], 0, 2);

        if (file_exists('lang.' . $language . '.php')) {

            $lang = $language;
            break;
        }

        ++$i;
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
