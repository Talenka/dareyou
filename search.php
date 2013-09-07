<?php

namespace Dareyou;

require_once 'core.php';

$search = isset($_POST['q']) ? $_POST['q'] : urldecode($_SERVER['QUERY_STRING']);
$search = preg_replace('/[^\w\(\)\: \-\.]/', '', $search);
$search = trim(preg_replace('/\s+/', ' ', $search));

$result = '';

if (!empty($search)) {
    $searchTerms = explode(' ', $search);

    $whereClause = array();

    foreach ($searchTerms as $term) {
        array_push($whereClause, 'title LIKE "%' . $db->real_escape_string($term) . '%"');
        array_push($whereClause, 'description LIKE "%' . $db->real_escape_string($term) . '%"');
    }

    $searchResults = array();

    $challengesResult = select('challenges',
                               'cid,title,description',
                               '(' . implode(' OR ', $whereClause) . ')',
                               50,
                               'created DESC');

    while ($c = $challengesResult->fetch_object()) {

        if (isset($searchResults['challenge_' . $c->cid])) $challengesResult['challenge_' . $c->cid]['hit']++;

        else $searchResults['challenge_' . $c->cid] = array('hit' => 1,
                                                            'title' => $c->title,
                                                            'url' => 'challenge?' . urlencode($c->title),
                                                            'summary' => $c->description);
    }

    if (sizeof($searchResults) == 0) $result = '<em>' . L('There is nothing like this here, sorry') . '</em>';

    else foreach ($searchResults as $key => $value) {
        $result .= h3(a($value['url'], utf8_encode($value['title']))) .
                   '<p>' . utf8_encode($value['summary']) . '</p>';
    }

    $challengesResult->free();
}

sendPageToClient(L('Search'),
                 h2(form('<input name=q id=q type=text placeholder="' . L('What are you looking for?') . '"' .
                         ' value="' . $search . '"' .
                         ' maxlength=255 required autofocus style=display:inline-block>' .
                         submitButton(L('Search'), 'class=g'),
                         'search onSubmit="window.location=\'search?\'+escape(document.getElementById(\'q\').value);return false"')) .
                 $result);
