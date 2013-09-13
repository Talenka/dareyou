<?php
/**
 * This page give specific informations about this website.
 */

namespace Dareyou;

require_once 'core.php';

$pageMaxAge = ONE_DAY;

$body = getFromCache('body', ONE_DAY);

if ($body === false)
    $body = cache('body',
            '<nav>' . a('contact class=b', L('Contact us')) . '</nav>' .
            h1(a('faq', L('Frequently Asked Questions'))) .
            '<ul>' .
                li('<a href=#ie>'.L('I cannot use Internet Explorer here, why?').'</a>') .
                li('<a href=#earn-karma>' . L('How to earn karma points?') . '</a>') .
                li('<a href=#referees>' . L('Who decides that a player has won a challenge?') . '</a>') .
                li('<a href=#buy-karma>' . L('Can I buy karma points?') . '</a>') .
                li('<a href=#privacy>' . L('My data will remain confidential?') . '</a>') .
            '</ul>' .

            '<h2 id=ie>' . L('I cannot use Internet Explorer here, why?').'</h2>' .
            '<p>' . L('IE is a mess') . '.</p>' .

            '<h2 id=earn-karma>' . L('How to earn karma points?') . '</h2>' .
            '<p align=justify>' . L('EARNKARMABYPLAYING') . '</p>' .

            '<h2 id=referees>' . L('Who decides that a player has won a challenge?') . '</h2>' .
            '<p align=justify>' . L('REFEREESDECIDE') . '</p>' .
            '<ul>' .
                li(L('From') . ' 1 ' . L('to') .' 10 ♣ : 1 ' . L('referee')) .
                li(L('From') . ' 11 ' . L('to') .' 100 ♣ : 2 ' . L('referees')) .
                li(L('From') . ' 101 ' . L('to') .' 1000 ♣ : 3 ' . L('referees')) .
                li(L('From') . ' 1001 ' . L('to') .' 10000 ♣ : 4 ' . L('referees')) .
                li(L('From') . ' 10001 ' . L('to') .' 100000 ♣ : 5 ' . L('referees')) .
                li('etc...') .
            '</ul>' .

            '<h2 id=buy-karma>' . L('Can I buy karma points?') . '</h2>' .
            '<p align=justify>' . L('NOYOUCANTBUYKARMA') . '</p>' .

            '<h2 id=privacy>' . L('My data will remain confidential?') . '</h2>' .
            '<p align=justify>' . L('YOURDATASTAYCONFIDENTIAL') . '</p>');

sendPageToClient(L('Frequently Asked Questions'), $body);
