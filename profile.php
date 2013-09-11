<?php
/**
 * Users profile page
 *
 * @todo use real data
 */

namespace Dareyou;

require_once 'core.php';

if (!empty($_SERVER['QUERY_STRING'])) {

    $name = $db->real_escape_string(strtolower(substr($_SERVER['QUERY_STRING'], 0, 20)));
    $sql  = select('users', '*', "name='" . $name . "'", 1);

    if ($sql->num_rows == 1) $user = $sql->fetch_object();
}

if (!isset($user)) {

    // If the specified user is not found, we display the current logged in client profile.
    if (isset($client)) $user = $client;
    else redirectTo(HOME, NOT_FOUND);
}

$html = '<nav>' .
        karmaButton($user->name, $user->karma) .
        gravatarProfileLink($user->mailHash) .
        ((isset($client) && $user->name == $client->name) ? ' ' . a('edit-profile class=t', L('Edit my profile')) : '') .
        '</nav>' .
        h2(ucfirst($user->name)) .
        h3('Stats & awards') .
        getAvatar($user->name, $user->mailHash) .
        '<ul>' .
            li('<a href="prize?awesomeness">Awesomeness prize</a>') .
            li('<a href="prize?barbarian">Barbarian prize</a>') .
            li('<a href="prize?dyonisos">Dyonisos prize</a>') .
            li('<a href=#completed-challenges>1 challenge completed</a>') .
            li('<a href=#accepted-challenges>3 challenge accepted</a>') .
        '</ul>' .
        h3('Recent activity') .
        '<ul>' .
            li('Some awesome news') .
            li('Lorem Ispum blah blah') .
            li('Lorem Ispum blah blah') .
            li('Lorem Ispum blah blah') .
            li('Lorem Ispum blah blah') .
        '</ul>';

$html .= '<h3 id=completed-challenges><b>5</b> Challenges completed</h3>' .
        '<ul>' .
            li('<a href=victory?1242>Some awesome challenge</a> : <b>+17 ♣</b> <time>(2 days ago)</time>') .
            li('<a href=victory?1242>Another awesome challenge</a> : <b>+7 ♣</b> <time>(4 days ago)</time>') .
            li('<a href=victory?1242>Another awesome challenge</a> : <b>+1 ♣</b> <time>(1 week ago)</time>') .
            li('<a href=victory?1242>Another awesome challenge</a> : <b>+8 ♣</b> <time>(2 months ago)</time>') .
            li('<a href=victory?1242>Another awesome challenge</a> : <b>+4 ♣</b> <time>(2 months ago)</time>') .
        '</ul>' .
        '<h3 id=accepted-challenges><b>5</b> Challenges accepted</h3>' .
        '<ul>' .
            li('<a href=challenge?1242>Some awesome challenge</a> <time>(2 days left)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(2 days left)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(2 days left)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(1 week left)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(1 year left)</time>') .
        '</ul>' .
        '<h3 id=failed-challenges><b>5</b> Challenges failed</h3>' .
        '<ul>' .
            li('<a href=challenge?1242>Some awesome challenge</a></li>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(yesterday)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(2 days ago)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(1 week ago)</time>') .
            li('<a href=challenge?1242>Another awesome challenge</a> <time>(2 weeks ago)</time>') .
        '</ul>';

sendPageToClient(ucfirst($user->name), $html);
