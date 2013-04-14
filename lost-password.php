<?php

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Lost password'),
                 '<h2>' . L('Have you lost your password ?') . '</h2>' .
                 '<p class=n>Sorry, but for the moment there is no way to reinitialize your password.</p>');
