<?php
/**
 * This script change the interface language and then returns to homepage.
 *
 * @todo store value in database for logged user ?
 */

namespace Dareyou;

require_once 'core.php';

// We sanitize the requested language
$l = preg_replace('/[^a-z]/', '', substr(strtolower(URL_PARAMS), 0, 2));

// If this language is known, we put a cookie for 1 year on the user browser
if (file_exists('lang.' . $l . '.php')) setcookie('lang', $l, NOW + 31536000);

redirectTo(HOME);
