<?php

namespace Dareyou;

require_once 'core.php';

$html = (isset($notice) ? '<div class=n>' . $notice . '</div>' : '') .
        '<h2><a href=victory>' . L('Last completed challenges') . '</a></h2>' .
        '<ul>' .
            challengesList('SELECT c.title,c.cid,r.value,r.end,u.name,u.mailHash ' .
                           'FROM realizations r,users u,challenges c ' .
                           "WHERE r.status='accepted' AND r.cid=c.cid AND r.uid=u.id " .
                           'ORDER BY r.end DESC LIMIT 5', 'won', 'value', 'end') .
        '</ul>' .
        '<h2><a href=new>' . L('New challenges') . '</a></h2><ul>' .
            challengesList('SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash ' .
                           'FROM challenges c,users u ' .
                           'WHERE c.author=u.id ' .
                           'ORDER BY c.created DESC LIMIT 5', 'issued', 'totalSum', 'created') .
        '</ul>' .
        '<h2><a href=top>' . L('Greatest challenges') . '</a></h2><ul>' .
            challengesList('SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash ' .
                           'FROM challenges c,users u ' .
                           'WHERE c.author=u.id ' .
                           'ORDER BY c.totalSum DESC LIMIT 5', 'issued', 'totalSum', 'created') .
        '</ul>';

$langs = array();

foreach ($definedLanguages as $lg => $language) {
    if ($lg != $lang) {
        $langs[] = '<a href=language?' . $lg . ' title=' . L($language) . '>' .
               $language . '</a>';
    }
}

sendPageToClient(L('What are you gonna do awesome today?'),
                '<nav>' .
                (isset($client) ?
                    '<a href=start-challenge class=b>' .
                    L('Start a challenge') . '</a> ' : '') .
                '<a href=about class=b>' . L('About') . '</a> ' .
                '<a href=faq class=b title="' .
                    L('Frequently Asked Questions') . '">FAQ</a></nav>' .
                '<h1>' . L('What are you gonna do awesome today?') . '</h1>' .
                $html .
                L('In other languages') . ' : ' . implode(', ', $langs));
?>