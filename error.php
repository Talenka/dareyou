<?php

include 'core.php';

sendPageToClient(lg('ERRMSG'),'<h2>'.lg('ERRMSG').'</h2><p>'.lg('Try to go back to').' <a href=# onClick="history.go(-1)">'.lg('the previous page').'</a> '.lg('or return to').' <a href=.>'.lg('the homepage').'</a>.</p>');

?>