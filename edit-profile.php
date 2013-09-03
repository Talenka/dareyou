<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToLoggedInUser();

        // if (in_array(strtolower($_POST['password']), $commonPasswords)) {
        //     $signupError[] = L('This password is too common, please choose another');
        // }

sendPageToClient(L('Edit my profile'),
    h1(L('Edit my profile')) .
    form(usernameField(false, $client->name) .
         usermailField() .
         L('If you want to change your password, fill both text fields below:') .
         userpasswordField() .
         '<input type=password name=password2 maxlength=255 placeholder="' . L('CONFIRMPASSWORD') . '" required>' .
         '<input type=submit value="' . L('Apply modifications') . '" class=g>') .

    h2('Danger zone') .
    L('If for some mysterious reason you wish, you can ') .
    a('delete-account style=color:red', L('delete your account')));
