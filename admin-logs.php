<?php
/**
 * This page shows normal and admin logs
 */

namespace Dareyou;

require_once 'core.php';

/** @var integer Age treshold for logs purge */
const LOG_MAX_AGE_IN_DAYS = 30;

restrictAccessToAdministrator();

$whereClause = '';

if (URL_PARAMS == 'purge')

    $db->query('DELETE FROM `logs` WHERE `date` < ' . ((int) (NOW - LOG_MAX_AGE_IN_DAYS * ONE_DAY)));

elseif (substr(URL_PARAMS, 0, 7) == 'search/') {

    $search = $db->real_escape_string(urldecode(substr(URL_PARAMS, 7)));

    $whereClause = ' AND (l.text LIKE "%' . $search . '%" OR ' .
                          'l.url LIKE "%' . $search . '%" OR ' .
                          'u.name LIKE "%' . $search . '%")';
}

$html = '';

$sql = select('logs l, users u', 'l.*,u.name,u.mailHash', 'l.user=u.id' . $whereClause, 100, 'l.date DESC');

while ($l = $sql->fetch_object())

    $html .= li(userLinkWithAvatar($l->name, $l->mailHash) . ' : ' . a($l->url, $l->text) .
                ' <time>(' . date(L('dateFormat'), $l->date) . ')</time>');

$sql->free();

sendPageToClient(L('Administration'),
                 h1(a('admin', L('Administration'))) .
                 '<nav style=text-align:right>' .
                 form('<input name=q id=q type=text ' .
                      'placeholder="' . L('What are you looking for?') . '" ' .
                      'value="' . (empty($search) ? '' : $search) . '" ' .
                      'maxlength=255 autofocus style=width:250px;display:inline-block>' .
                      submitButton(L('Search'), 'class=g'),
                      '"admin-logs?search/" onSubmit="' .
                      'return !(window.location=\'admin-logs?search/\'+escape(document.getElementById(\'q\').value))"') .
                 '</nav>' .
                 h2(a('admin-logs', L('Logs'))) .
                 '<ul>' . $html . '</ul>' .
                 '<h2>&nbsp;</h2>' .
                 a('admin-logs?purge class="b w"', 'Purge') .
                 ' logs older than ' . LOG_MAX_AGE_IN_DAYS . ' days');
