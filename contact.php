<?php

namespace Dareyou;

require_once 'core.php';

$pageTitle = L('Contact');

$html = h1($pageTitle);

sendPageToClient($pageTitle, $html);
