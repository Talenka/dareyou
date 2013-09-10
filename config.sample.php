<?php
/**
 * This script is the fac-simile configuration file
 *
 * To start, you have to edit this file according to your configuration, then
 * rename it as config.php, and it's done.
 */

namespace Dareyou;

// Uncomment the line below for debugging purpose:
// error_reporting(E_ALL);

// The <title> of the site
const 'SITE_TITLE' = 'DareYou!';

// The password hashing salt (please choose a long and unique one)
const 'CRYPT_SALT' = 'KM4WcTe+tiPzmkc{';

// The MySql database host ("localhost" in 99% of cases)
const 'SQL_HOST' = 'localhost';

// The MySql database username
const 'SQL_USER' = 'myhumblesite';

// The MySql database password (please choose a long and unique one)
const 'SQL_PASSWORD' = 'b62kH043b6wt4T6Q';

// Your MySql database name
const 'SQL_DB' = 'humblesite';

// The MD5 digest of admin email (yours maybe)
const 'ADMIN_HASH' = '00000000000000000000000000000000';

// The canonical domain name
const 'SERVER_NAME' = 'dareyou2.be';
