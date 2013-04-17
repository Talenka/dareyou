<?php

namespace Dareyou;

require_once 'core.php';

$html = h2(L('Have you lost your password ?')) .
        '<p class=n>Sorry, but for the moment there is no way to reinitialize' .
        ' your password.</p>' .
        '<form action=lost_password method=post>' .
        '<input type=email name=mail maxlength=255 ' .
        'placeholder="' . L('Email') . '" required>' .
        '<input type=submit class=g disabled value="' .
        L('Send me a link to reinitialize my password') . '">' .
        generateFormKey() . '</form>';

sendPageToClient(L('Lost password'), $html);