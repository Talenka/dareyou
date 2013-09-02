<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

$pageTitle = L('Administration');

$html = h1($pageTitle) .
        '<nav>' .
        a('admin-users', 'Users') .
        '</nav>';

sendPageToClient($pageTitle, $html);
