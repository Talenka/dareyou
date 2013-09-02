<?php

namespace Dareyou;

require_once 'core.php';

// If no name is specified in the URL, this is a bad request.
if (empty($_SERVER['QUERY_STRING'])) redirectTo(HOME, 400);

// We look in the database for the challenge with the specified name
$challenge = select('challenges c, users u', 'c.*,u.name,u.mailHash',
                    'c.title="' . addslashes($db->real_escape_string(urldecode($_SERVER['QUERY_STRING']))) .
                    '" AND c.author=u.id', 1);

// If there is no result, respond to user that the challenge is not found.
if ($challenge->num_rows == 0) redirectTo(HOME, 404);
// Else if there is more than one result, these is a bug (or an SQL injection).
else if ($challenge->num_rows > 1) redirectTo(HOME, 500);

$c = $challenge->fetch_object();

$attemptsNumber = selectCount('realizations', 'cid=' . (int) $c->cid);

sendPageToClient(utf8_encode($c->title),
                 h1('<a href="challenge?' . urlencode($c->title) . '">' .
                 utf8_encode($c->title) . '</a> <strong class=g>' .
                 $c->totalSum . ' ♣</strong> <strong class=b>' .
                 $c->forSum . ' ▲ – ' . $c->againstSum . ' ▼</strong>') .
                 '<p>' . utf8_encode($c->description) . '</p><ul>' .
                 li(L('Time to complete the challenge:') .
                 ' <strong>' . $c->timeToDo . '</strong> ' . L('days')) .
                 li(L('Bettors have wagered a total of ') .
                 ' <strong>' . $c->totalSum . ' ♣</strong> ' .
                 L('on this challenge')) . li(L('Challenge').' '.L('issued') .
                 ' ' . L('by') . ' <time>(' .
                 date(L('dateFormat'), $c->created) . ')</time>.') .
                 '</ul>' . h3('<strong>' . $attemptsNumber . '</strong> ' .
                 L( ($attemptsNumber > 1) ? 'buddies' : 'buddy' ) . ' ' .
                 L('have tried the adventure')) .
                 $c->lang . '<br>' .
                 $c->image);

// TODO : lang image completed
