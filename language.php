<?php

namespace Dareyou;

require_once 'core.php';

$l = preg_replace('/[^a-z]/', '', strtolower($_SERVER['QUERY_STRING']));

if (file_exists('lang.' . $l . '.php')) {
    setcookie('lang', $l, NOW + 31536000);
}

redirectTo('.');
