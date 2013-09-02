<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToLoggedInUser();

deleteSessionCookie();

$db->query('UPDATE users SET session="" WHERE session="' .
           generateSessionId($db->real_escape_string(getSessionCookie())) .
           '" LIMIT 1');

unset($client);

$notice = L('You have been logged out. Goodbye !');

require_once 'index.php';

exit;
