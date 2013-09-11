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

/** @var string The <title> of the site */
const SITE_TITLE = 'DareYou!';

/** @var string The password hashing salt (please choose a long and unique one) */
const CRYPT_SALT = 'KM4WcTe+tiPzmkc{';

/** @var string The MySql database host ("localhost" in 99% of cases) */
const SQL_HOST = 'localhost';

/** @var string The MySql database username */
const SQL_USER = 'myhumblesite';

/** @var string The MySql database password (choose a long and unique one) */
const SQL_PASSWORD = 'b62kH043b6wt4T6Q';

/** @var string Your MySql database name */
const SQL_DB = 'humblesite';

/** @var string The MD5 digest of admin email (yours maybe) */
const ADMIN_HASH = '00000000000000000000000000000000';

/** @var string The canonical domain name */
const SERVER_NAME = 'dareyou2.be';
