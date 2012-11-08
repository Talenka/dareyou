<?php

include 'core.php';

$usersList = $db->query("SELECT * FROM users");

$html = '<h2>'.lg('Users administration').'</h2>'
		.'<h3>Users list</h3><ul>';

while($u = $usersList->fetch_object())
{
	$html .= '<li>'.userLinkWithAvatar($u->name, $u->mailHash).' '.karmaButton($u->name, $u->karma).'</li>';
}

$html .= '</ul>';

sendPageToClient(lg('Users administration'), $html);

?>