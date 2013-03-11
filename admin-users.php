<?php

include 'core.php';

$pageTitle = L('Users administration');

$usersList = $db->query("SELECT * FROM users");

$html = '<h2>'.$pageTitle.'</h2>'
		.'<h3>Users list</h3><ul>';

while($u = $usersList->fetch_object())
{
	$html .= '<li>'.userLinkWithAvatar($u->name, $u->mailHash).' '.karmaButton($u->name, $u->karma).'</li>';
}

$html .= '</ul>';

sendPageToClient($pageTitle, $html);

?>