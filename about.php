<?php
include 'core.php';

$playersNumber    = $db->query("SELECT COUNT(*) AS n FROM users")->fetch_object()->n;
$challengesNumber = $db->query("SELECT COUNT(*) AS n FROM challenges")->fetch_object()->n;
$attemptsNumber   = $db->query("SELECT COUNT(*) AS n FROM realizations")->fetch_object()->n;
$betsNumber       = $db->query("SELECT COUNT(*) AS n FROM bets")->fetch_object()->n;
$commentsNumber   = $db->query("SELECT COUNT(*) AS n FROM comments")->fetch_object()->n;
$successfulAttempts = round(100 * $db->query("SELECT COUNT(*) AS n FROM realizations WHERE status='accepted'")->fetch_object()->n / $attemptsNumber);

sendPageToClient(lg('About'),'<h2>'.lg('About').'</h2>'
    .'<h3>'.lg('How it works').'</h3>'
    .'<p align=justify>'.lg('How it works ...').'</p>'
    .'<h3>'.lg('Some figures').'</h3>'
    .'<ul>'
        .'<li>'.lg('Players').' : <strong>'.$playersNumber.'</strong></li>'
        .'<li>'.lg('Challenges').' : <strong>'.$challengesNumber.'</strong></li>'
        .'<li>'.lg('Attempts').' : <strong>'.$attemptsNumber.'</strong> ('.$successfulAttempts.lg('% successful').')</li>'
        .'<li>'.lg('Bets').' : <strong>'.$betsNumber.'</strong></li>'
        .'<li>'.lg('Comments').' : <strong>'.$commentsNumber.'</strong></li>'
    .'</ul>'
    .'<h3>'.lg('Under the hood').'</h3>'
    .SITE_TITLE.lg(' is a project of ').'<a href="//boudah.pl" target=_blank>Boudah Talenka</a>, '
    .'<a href="//www.gnu.org/licenses/gpl.html" target=_blank>'.lg('published under the GPL3+ licence').'</a>'
    .' '.lg('and').' '.'<a href="//github.com/talenka/dareyou" target=_blank>'.lg('freely available on Github').'</a>.');
    


?>