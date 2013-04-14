<?php

namespace Dareyou;

require_once 'core.php';

$pageTitle = L('Administration');

$html = '<h1>' . $pageTitle . '</h1>' .
        '<nav>' .
        '<a href=admin-users>Users</a>' .
        '</nav>';


sendPageToClient($pageTitle, $html);
