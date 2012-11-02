<?php

include 'core.php';

sendPageToClient(lg('Last completed challenges'),
    '<h2>'.lg('Last completed challenges').'</h2>'
    .'<ul>'
        .challengesList("SELECT r.value,r.end,u.name,u.mailHash,c.title,c.cid "
            ."FROM realizations r,users u,challenges c "
            ."WHERE r.status='accepted' AND r.cid=c.cid AND r.uid=u.id "
            ."ORDER BY r.end DESC LIMIT 30",'won','value','end')
    .'</ul>');
?>