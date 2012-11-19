<?php
include 'core.php';


$html .= '<h2><a href=victory>'.lg('Last completed challenges').'</a></h2>'
        .'<ul>'
        	.challengesList("SELECT c.title,c.cid,r.value,r.end,u.name,u.mailHash "
        				   ."FROM realizations r,users u,challenges c "
        				   ."WHERE r.status='accepted' AND r.cid=c.cid AND r.uid=u.id "
        				   ."ORDER BY r.end DESC LIMIT 5", 'won', 'value', 'end')
        .'</ul>'
        .'<h2><a href=new>'.lg('New challenges').'</a></h2><ul>'
        	.challengesList("SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash "
        				   ."FROM challenges c,users u "
        				   ."WHERE c.author=u.id "
        				   ."ORDER BY c.created DESC LIMIT 5", 'issued', 'totalSum', 'created')
        .'</ul>'
        .'<h2><a href=top>'.lg('Greatest challenges').'</a></h2><ul>'
        	.challengesList("SELECT c.title,c.cid,c.totalSum,c.created,u.name,u.mailHash "
        				   ."FROM challenges c,users u "
        				   ."WHERE c.author=u.id "
        				   ."ORDER BY c.totalSum DESC LIMIT 5", 'issued', 'totalSum', 'created')
        .'</ul>';

$langs = array();

foreach($definedLanguages as $lang => $language) $langs[] = '<a href=language?'.$lang.' title="'.lg($language).'">'.$language.'</a>';

sendPageToClient(lg('What are you gonna do awesome today?'),
                '<nav><a href=about class=btn>'.lg('About').'</a> <a href=faq class=btn title="'.lg('Frequently Asked Questions').'">FAQ</a></nav>'
                .'<h1>'.lg('What are you gonna do awesome today?').'</h1>'
                .$html.lg('In other languages').' : '.implode(', ', $langs));
?>