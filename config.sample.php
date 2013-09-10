<?php
/**
 * This script is the fac-simile configuration file
 *
 * To start, you have to edit this file according to your configuration, then
 * rename it as config.php, and it's done.
 *
 * @todo if php_version > 5.3, use const instead of define() for performance.
 */

namespace Dareyou;

// Uncomment the line below for debugging purpose:
// error_reporting(E_ALL);

// The <title> of the site
define('SITE_TITLE', 'DareYou!');

// The password hashing salt (please choose a long and unique one)
define('CRYPT_SALT', 'KM4WcTe+tiPzmkc{');

// The MySql database host ("localhost" in 99% of cases)
define('SQL_HOST', 'localhost');

// The MySql database username
define('SQL_USER', 'myhumblesite');

// The MySql database password (please choose a long and unique one)
define('SQL_PASSWORD', 'b62kH043b6wt4T6Q');

// Your MySql database name
define('SQL_DB', 'humblesite');

// The MD5 digest of admin email (yours maybe)
define('ADMIN_HASH', '00000000000000000000000000000000');

// The canonical domain name
define('SERVER_NAME', 'dareyou2.be');
