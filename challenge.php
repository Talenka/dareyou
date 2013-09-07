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
if ($challenge->num_rows === 0) redirectTo(HOME, 404);
// Else if there is more than one result, these is a bug (or an SQL injection).
else if ($challenge->num_rows > 1) redirectTo(HOME, 500);

$c = $challenge->fetch_object();

$challenge->free();

$attemptsNumber = selectCount('realizations', 'cid=' . (int) $c->cid);

// duration : P[n]D

$html = '<article itemscope itemtype="http://schema.org/CreativeWork">' .
        h1('<a href="challenge?' . urlencode($c->title) . '" itemprop=name>' .
           utf8_encode($c->title) . '</a> <strong class=g>' . $c->totalSum . ' ♣</strong>' .
           ' <strong class=b>' . $c->forSum . ' ▲ – ' . $c->againstSum . ' ▼</strong>') .
           a('"' . $c->image . '" target=_blank', '<img src="' . $c->image . '" class=i' .
           ' itemprop=image alt="' . utf8_encode($c->title) . '">') .
           '<p itemprop=description>' . utf8_encode($c->description) . '</p><ul>' .
           li(L('Time to complete the challenge:') . ' <strong itemprop=timeRequired content="P' . $c->timeToDo . 'D">' .
              $c->timeToDo . '</strong> ' . L('days')) .
           li(L('Bettors have wagered a total of ') . ' <strong>' . $c->totalSum . ' ♣</strong> ' .
           L('on this challenge')) . li(L('Challenge') . ' ' . L('issued') . ' ' .
           L('by') . userLinkWithAvatar($c->name, $c->mailHash, ' itemprop=author') .
           ' <time itemprop=dateCreated datetime="' . date('c', $c->created) . '">(' .
               date(L('dateFormat'), $c->created) . ')</time>.') .
           '</ul>' .
           h3((($attemptsNumber > 1) ? '<strong>' . $attemptsNumber . '</strong>' : '') . ' ' .
           L(($attemptsNumber > 1) ? 'people have tried' :
             (($attemptsNumber == 0) ? 'No one has tried' : 'One people has tried')) . ' ' . L('the adventure')) .
           L('Language:') .
           ' <b itemprop=inLanguage content="' . $c->lang . '">' . L($definedLanguages[$c->lang]) . '</b>';

// TODO : completed

$comments = select('comments c, users u', 'u.name,u.mailHash,c.comtext,comdate', 'u.id=c.comauthor', 30, 'c.comdate ASC');

if ($comments->num_rows == 0) $html .= '<em>' . L('No comment on this challenge yet') . '</em>';

else {

    $html .= h2(($comments->num_rows == 1) ? L('One comment') : $comments->num_rows . ' ' . L('Comments')) .
             '<ul itemprop=comment>';

    while ($comment = $comments->fetch_object())

        $html .= '<li itemscope itemtype="http://schema.org/Comment">' .
                 '<p itemprop=text>' . utf8_encode($comment->comtext) . '</p>' .
                 L('by') . ' ' . userLinkWithAvatar($comment->name, $comment->mailHash, ' itemprop=author') .
                 ' <time itemprop=datePublished datetime="' .date('c', $comment->comdate) . '">(' .
                     date(L('dateFormat', $comment->comdate)) . ')</time>' .
                 '</li>';

    $html .= '</ul>';
}

$comments->free();

$html .= '</article>';

sendPageToClient(utf8_encode($c->title), $html);
