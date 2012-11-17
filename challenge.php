<?php

include 'core.php';

if(!empty($_SERVER['QUERY_STRING']))
{
	
	$challengeSql = $db->query("SELECT * FROM challenges WHERE title='".addslashes($db->real_escape_string(urldecode($_SERVER['QUERY_STRING'])))."' LIMIT 1");

	if($challengeSql->num_rows == 1)
	{
		$challenge = $challengeSql->fetch_object();

		sendPageToClient(utf8_encode($challenge->title),
						'<h2>'.utf8_encode($challenge->title).'</h2>'
						.'<p>'.utf8_encode($challenge->description).'</p>'
						.lg('Challenge').' '.lg('issued').' '.lg('by').' '.$challenge->author);

		//cid 	lang 	title 	author 	description 	image 	created 	timeToDo 	forSum 	againstSum 	completed 	totalSum
	}
	else redirectTo('/');
}
else redirectTo('/');

?>