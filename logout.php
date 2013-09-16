<?php
/**
 * User logging out
 */

namespace Dareyou;

require_once 'core.php';

restrictAccessToLoggedInUser();

// $db->query('UPDATE users SET session="" WHERE session="' .
//            generateSessionId(realEscapeString(getSessionCookie())) . '" LIMIT 1');

dbUpdate('users', 'session=""', 'session="' . generateSessionId(realEscapeString(getSessionCookie())) . '"');

deleteSessionCookie();

logActivity('Logout');

unset($client);

$notice = L('You have been logged out. Goodbye !');

require_once 'index.php';

exit;
