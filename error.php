<?php

include 'core.php';

$pageTitle = L('Oups, something wrong happen!');

$html = '<h1>'.$pageTitle.'</h1>'
        .'<tt>'.urldecode($_SERVER['QUERY_STRING']).'</tt>'
        .'<p>'
            .L('Try to go back to').' <a href=# onClick="history.go(-1)">'.L('the previous page').'</a> '
            .L('or return to').' <a href=.>'.L('the homepage').'</a>.'
        .'</p>';

sendPageToClient($pageTitle, $html);

?>