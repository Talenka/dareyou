<?php

include 'core.php';

deleteSessionCookie();

$db->query("UPDATE users SET session='' WHERE session='"
    .generateSessionId($db->real_escape_string(getSessionCookie()))."' LIMIT 1");

unset($client);

$notice = lg('You have been logged out. Goodbye !');

include "index.php";
exit;

?>