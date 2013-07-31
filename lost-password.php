<?php

namespace Dareyou;

require_once 'core.php';

$html = h2(L('Have you lost your password ?')) .
        '<p class=n>Sorry, but for the moment there is no way to reinitialize' .
        ' your password.</p>' .
        form('lost_password', usermailFormInput() .
        '<input type=submit class=g disabled value="' .
        L('Send me a link to reinitialize my password') . '">');

sendPageToClient(L('Lost password'), $html);
