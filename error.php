<?php

include 'core.php';

sendPageToClient(lg('Oups, something wrong happen!'),'<h1>'.lg('Oups, something wrong happen!').'</h1><p>'.lg('Try to go back to').' <a href=# onClick="history.go(-1)">'.lg('the previous page').'</a> '.lg('or return to').' <a href=.>'.lg('the homepage').'</a>.</p>');

?>