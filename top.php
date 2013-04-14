<?php

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Greatest challenges'),
    '<h1><a href=top>' . L('Greatest challenges') . '</a></h1>' .
    '<ul>' .
    challengesList('SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash ' .
        'FROM challenges c,users u WHERE c.author=u.id ' .
        'ORDER BY c.totalSum DESC LIMIT 20', 'issued', 'totalSum', 'created') .
    '</ul>');
