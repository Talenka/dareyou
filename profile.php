<?php
include 'core.php';

if(!empty($_SERVER['QUERY_STRING']))
{
    $name = $db->real_escape_string(strtolower(substr($_SERVER['QUERY_STRING'], 0, 20)));
    $sql  = $db->query("SELECT * FROM users WHERE name='".$name."' LIMIT 1");
    if($sql->num_rows == 1) $user = $sql->fetch_object();
}

if(!isset($user))
{
    if(isset($client)) $user = $client;
    else redirectTo('.');
}

sendPageToClient(ucfirst($user->name), 
        '<nav>'.karmaButton($user->name,$user->karma)
            .gravatarProfileLink($user->mailHash).'</nav>'
        .'<h2>'.ucfirst($user->name).'</h2>'
        .'<h3>Stats & awards</h3>'
        .getAvatar($user->name, $user->mailHash)
        .'<ul>'
            .'<li><a href="prize?awesomeness">Awesomeness prize</a></li>'
            .'<li><a href="prize?barbarian">Barbarian prize</a></li>'
            .'<li><a href="prize?dyonisos">Dyonisos prize</a></li>'
            .'<li><a href=#challenge-completed>1 challenge completed</a></li>'
            .'<li><a href=#challenge-accepted>3 challenge accepted</a></li>'
        .'</ul>'
        .'<h3>Recent activity</h3>'
        .'<a href="http://knowyourmeme.com/memes/true-story" target=_blank>'
        .'<img src="img/true-story" width=128 height=128 align=right>'
        .'</a>'
        .'<ul>'
            .'<li>Some awesome news</li>'
            .'<li>Lorem Ispum blah blah</li>'
            .'<li>Lorem Ispum blah blah</li>'
            .'<li>Lorem Ispum blah blah</li>'
            .'<li>Lorem Ispum blah blah</li>'
        .'</ul>'
        .'<h3 id=challenge-completed><b>5</b> Challenges completed</h3>'
        .'<a href="http://knowyourmeme.com/memes/fck-yea" target=_blank>'
        .'<img src="img/fyeah" width=128 height=122 align=right>'
        .'</a>'
        .'<ul>'
            .'<li><a href=victory?1242>Some awesome challenge</a> : <b>+17 ♣</b> <time>(2 days ago)</time></li>'
            .'<li><a href=victory?1242>Another awesome challenge</a> : <b>+7 ♣</b> <time>(4 days ago)</time></li>'
            .'<li><a href=victory?1242>Another awesome challenge</a> : <b>+1 ♣</b> <time>(1 week ago)</time></li>'
            .'<li><a href=victory?1242>Another awesome challenge</a> : <b>+8 ♣</b> <time>(2 months ago)</time></li>'
            .'<li><a href=victory?1242>Another awesome challenge</a> : <b>+4 ♣</b> <time>(2 months ago)</time></li>'
        .'</ul>'
        .'<h3 id=challenge-accepted><b>5</b> Challenges accepted</h3>'
        .'<a href="http://knowyourmeme.com/memes/challenge-accepted">'
        .'<img src="img/challenge-accepted" width=128 height=128 align=right>'
        .'</a>'
        .'<ul>'
            .'<li><a href=challenge?1242>Some awesome challenge</a> <time>(2 days left)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(2 days left)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(2 days left)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(1 week left)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(1 year left)</time></li>'
        .'</ul>'
        .'<h3 id=challenge-failed><b>5</b> Challenges failed</h3>'
        .'<a href="http://knowyourmeme.com/memes/rage-guy-fffffuuuuuuuu">'
        .'<img src="img/ffffuuuu" width=128 height=96 align=right>'
        .'</a>'
        .'<ul>'
            .'<li><a href=challenge?1242>Some awesome challenge</a></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(yesterday)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(2 days ago)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(1 week ago)</time></li>'
            .'<li><a href=challenge?1242>Another awesome challenge</a> <time>(2 weeks ago)</time></li>'
        .'</ul>');
?>