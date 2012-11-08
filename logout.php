<?php

include 'core.php';

if($db->query("UPDATE users SET session='' WHERE session='"
				.generateSessionId($db->real_escape_string(getSessionCookie()))."' LIMIT 1")
	&& deleteSessionCookie())
	redirectTo('.');
else displayError('User cannot be logged out');

?>