<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToLoggedInUser();

sendPageToClient(L('Delete your account'), h2(L('Delete your account')) . L('This service is under construction.'));
