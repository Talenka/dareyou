<?php

include 'core.php';

if(deleteSessionCookie()) redirectTo('.');
else displayError('User cannot be logged out');

?>