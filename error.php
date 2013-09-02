<?php
/**
 * This page displays an error message that comes with a link to homepage.
 */

namespace Dareyou;

require_once 'core.php';

header('Status: 500 Internal Server Error', false, 500);

sendPageToClient(L('ERRMSG'), h1(L('ERRMSG')) .
        '<tt>' . urldecode($_SERVER['QUERY_STRING']) . '</tt>' .
        '<p>' . L('Try to go back to') .
        ' <a href=# onClick="history.go(-1)">' . L('the previous page') .
        '</a> ' . L('or return to') . ' <a href=.>' . L('the homepage') .
        '</a>.</p>');
