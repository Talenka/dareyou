<?php

include 'core.php';

sendPageToClient(lg('New challenges'),
				'<h2>'.lg('New challenges').'</h2>'
				.'<ul>'
					.challengesList("SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash "
								   ."FROM challenges c,users u "
								   ."WHERE c.author=u.id "
								   ."ORDER BY c.created DESC LIMIT 20",'issued','totalSum','created').'</ul>');

?>