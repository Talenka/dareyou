<?php

include 'core.php';

sendPageToClient(lg('Challenges'),'<h2>'.lg('Challenges').'</h2>');

if(!empty($_SERVER['QUERY_STRING'])
	&& (int) $_SERVER['QUERY_STRING'] == $_SERVER['QUERY_STRING']
	&& (int) $_SERVER['QUERY_STRING'] >= 0) {


}
else redirectTo('/');

?>