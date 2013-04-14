<?php

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Last completed challenges'),
    '<h1><a href=victory>' . L('Last completed challenges') . '</a></h1>' .
    '<ul>' .
        challengesList('SELECT r.value,r.end,u.name,u.mailHash,c.title,c.cid ' .
            'FROM realizations r,users u,challenges c ' .
            "WHERE r.status='accepted' AND r.cid=c.cid AND r.uid=u.id " .
            'ORDER BY r.end DESC LIMIT 30', 'won', 'value', 'end') .
    '</ul>');
