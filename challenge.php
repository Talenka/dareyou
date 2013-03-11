<?php

include 'core.php';

if(!empty($_SERVER['QUERY_STRING']))
{
	$challenge = $db->query("SELECT c.*,u.name,u.mailHash "
							."FROM challenges c, users u "
							."WHERE c.title='".addslashes($db->real_escape_string(urldecode($_SERVER['QUERY_STRING'])))."' AND c.author=u.id LIMIT 1");

	if($challenge->num_rows == 1)
	{
		$c = $challenge->fetch_object();

		$attemptsNumber = $db->query("SELECT COUNT(*) AS n FROM realizations WHERE cid=".((int) $c->cid))->fetch_object()->n;

		sendPageToClient(utf8_encode($c->title),
						'<h1><a href="challenge?'.urlencode($c->title).'">'.utf8_encode($c->title).'</a>'
								.' <strong class="btn green">'.$c->totalSum.' ♣</strong>'
								.' <strong class="btn">'.$c->forSum.' ▲ – '.$c->againstSum.' ▼</strong>'
						.'</h1>'
						.'<p>'.utf8_encode($c->description).'</p>'
						.'<ul>'
						.'<li>'.L('Time to complete the challenge:').' <strong>'.$c->timeToDo.'</strong> '.L('days').'</li>'
						.'<li>'.L('Bettors have wagered a total of ').' <strong>'.$c->totalSum.' ♣</strong> '.L('on this challenge').'</li>'
						.'<li>'.L('Challenge').' '.L('issued').' '.L('by').' '.userLinkWithAvatar($c->name,$c->mailHash).' '
						.'<time>('.date(L('dateFormat'),$c->created).')</time>.').'</li>'
						.'</ul>'
						.'<h3><strong>'.$attemptsNumber.'</strong> '.L( ($attemptsNumber > 1)?'buddies':'buddy' ).' '.L('have tried the adventure').'</h3>';

		//lang image ▲	forSum 	▼ againstSum 	completed
	}
	else redirectTo('/');
}
else redirectTo('/');

?>