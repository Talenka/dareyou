<?php
/**
 * This script change the interface language and then returns to homepage.
 */

namespace Dareyou;

require_once 'core.php';

// We sanitize the requested language
$l = preg_replace('/[^a-z]/', '', strtolower($_SERVER['QUERY_STRING']));

// If this language is known, we put a cookie for 1 year on the user browser
if (file_exists('lang.' . $l . '.php')) setcookie('lang', $l, NOW + 31536000);

redirectTo(HOME);
