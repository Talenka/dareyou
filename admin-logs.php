<?php

namespace Dareyou;

require_once 'core.php';

restrictAccessToAdministrator();

$sql = select('logs l, users u', 'l.*,u.name,u.mailHash', 'l.user=u.id', 50, 'l.date DESC');

$html = '';

while ($l = $sql->fetch_object())

    $html .= li(userLinkWithAvatar($l->name, $l->mailHash) . ' : ' . a($l->url, $l->text) .
                ' <time>(' . date(L('dateFormat'), $l->date) . ')</time>');

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 h2(a('admin-logs', L('Logs'))) . '<ul>' . $html . '</ul>');
