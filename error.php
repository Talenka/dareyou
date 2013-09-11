<?php
/**
 * This page displays an error message that comes with a link to homepage.
 *
 * @todo log activity ?
 */

namespace Dareyou;

require_once 'core.php';

header('Status: 500 Internal Server Error', false, 500);

sendPageToClient(L('ERRMSG'), a(HOME, h1(L('ERRMSG'))) .
        '<tt>' . urldecode(URL_PARAMS) . '</tt>' .
        '<p>' . L('Try to go back to') .
        ' <a href=# onClick="history.go(-1)">' . L('the previous page') .
        '</a> ' . L('or return to') . ' ' .
        a(HOME . ' class="b g"', L('the homepage')) . '</p>' .
        '<p>' . L('If the problem persists, do not hesitate') . ' ' .
        a('contact', L('to contact us')) . '.');
