<?php
include 'core.php';

$playersNumber    = $db->query("SELECT COUNT(*) AS n FROM users")->fetch_object()->n;
$challengesNumber = $db->query("SELECT COUNT(*) AS n FROM challenges")->fetch_object()->n;
$attemptsNumber   = $db->query("SELECT COUNT(*) AS n FROM realizations")->fetch_object()->n;
$betsNumber       = $db->query("SELECT COUNT(*) AS n FROM bets")->fetch_object()->n;
$commentsNumber   = $db->query("SELECT COUNT(*) AS n FROM comments")->fetch_object()->n;
$successfulAttempts = round(100 * $db->query("SELECT COUNT(*) AS n FROM realizations WHERE status='accepted'")->fetch_object()->n / $attemptsNumber);

sendPageToClient(L('About'),'<h2>'.L('About').'</h2>'
    .'<h3>'.L('How it works').'</h3>'
    .'<p align=justify>'.L('How it works ...').'</p>'
    .'<h3>'.L('Some figures').'</h3>'
    .'<ul>'
        .'<li>'.L('Players').' : <strong>'.$playersNumber.'</strong></li>'
        .'<li>'.L('Challenges').' : <strong>'.$challengesNumber.'</strong></li>'
        .'<li>'.L('Attempts').' : <strong>'.$attemptsNumber.'</strong> ('.$successfulAttempts.L('% successful').')</li>'
        .'<li>'.L('Bets').' : <strong>'.$betsNumber.'</strong></li>'
        .'<li>'.L('Comments').' : <strong>'.$commentsNumber.'</strong></li>'
    .'</ul>'
    .'<h3>'.L('Under the hood').'</h3>'
    .SITE_TITLE.L(' is a project of ').'<a href="//boudah.pl" target=_blank>Boudah Talenka</a>, '
    .'<a href="//www.gnu.org/licenses/gpl.html" target=_blank>'.L('published under the GPL3+ licence').'</a>'
    .' '.L('and').' '.'<a href="//github.com/talenka/dareyou" target=_blank>'.L('freely available on Github').'</a>.');
    


?>