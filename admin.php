<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-logs', L('Logs'))) .
                 h2(a('admin-users', L('Users'))) .
                 h2(a('admin-challenges', L('Challenges'))) .
                 h2(a('admin-operations', L('Operations'))));
