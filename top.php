<?php

include 'core.php';

sendPageToClient(lg('Greatest challenges'),
    '<h2>'.lg('Greatest challenges').'</h2>'
    .'<ul>'
    .challengesList("SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash "
        ."FROM challenges c,users u WHERE c.author=u.id "
        ."ORDER BY c.totalSum DESC LIMIT 20",'issued','totalSum','created')
    .'</ul>');

?>