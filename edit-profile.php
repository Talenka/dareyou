<?php

namespace Dareyou;

require_once 'core.php';

$html = form('edit-profile', usernameFormInput() . usermailFormInput() .
        userpasswordFormInput() .
        '<input type=password name=password2 maxlength=255 ' .
            'placeholder="' . L('CONFIRMPASSWORD') . '" required>' .
        '<input type=submit value="' . L('Apply modifications') . '" class=g>');

sendPageToClient(L('Edit my profile'), $html);
