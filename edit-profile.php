<?php

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Edit my profile'),
    h1(L('Edit my profile')) .
    form('edit-profile',
        usernameFormInput(false, $client->name) .
        usermailFormInput() .
        L('If you want to change your password, fill both text fields below:') .
        userpasswordFormInput() .
        '<input type=password name=password2 maxlength=255 placeholder="' . L('CONFIRMPASSWORD') . '" required>' .
        '<input type=submit value="' . L('Apply modifications') . '" class=g>') .

    h2('Danger zone') .
    L('If for some mysterious reason you wish, you can ') .
    a('delete-account style=color:red', L('delete your account')));
