<?php
/**
 * Users profile page
 *
 * @todo use real data
 * @todo cache data
 */

namespace Dareyou;

require_once 'core.php';

if (URL_PARAMS != '') {

    $name = realEscapeString(strtolower(substr(URL_PARAMS, 0, 20)));
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
        ((isset($client) && $user->name == $client->name) ?
            ' ' . a('edit-profile class=t', L('Edit my profile')) : '') .
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

$completedChallenges = selectCount('realizations',
                                   'uid=' . ((int) $client->id) . ' AND status="done"');

if ($completedChallenges > 0)
    $html .= '<h3 id=completed-challenges><b>' . $completedChallenges . '</b> ' .
             L('challenges completed') . '</h3>' .
             challengesList(true, 'r.status="done"', 'r.end DESC');

$acceptedChallenges = selectCount('realizations',
                                  'uid=' . ((int) $client->id) . ' AND status="accepted"');

if ($acceptedChallenges > 0)
    $html .= '<h3 id=accepted-challenges><b>' . $acceptedChallenges . '</b> ' .
             L('challenges completed') . '</h3>' .
             challengesList(true, 'r.status="accepted"', 'r.end DESC');

$failedChallenges = selectCount('realizations',
                                'uid=' . ((int) $client->id) . ' AND status="failed"');

if ($failedChallenges > 0)
    $html .= '<h3 id=failed-challenges><b>' . $failedChallenges . '</b> ' .
             L('challenges failed') . '</h3>' .
             challengesList(true, 'r.status="failed"', 'r.end DESC');

sendPageToClient(ucfirst($user->name), $html);
