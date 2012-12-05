<?php
include 'core.php';

$signupError = array();

// Here is the list of common passwords, which are forbidden to use on this website 
$commonPasswords = array("123456","porsche","firebird","prince","rosebud","password","guitar","butter","beach","jaguar","12345678","chelsea","united","amateur",
                    "great","1234","black","turtle","7777777","cool","pussy","diamond","steelers","muffin","cooper","12345","nascar","tiffany","redsox","1313",
                    "dragon","jackson","zxcvbn","star","scorpio","qwerty","cameron","tomcat","testing","mountain","696969","654321","golf","shannon","madison",
                    "mustang","computer","bond007","murphy","987654","letmein","amanda","bear","frank","brazil","baseball","wizard","tiger","hannah","lauren",
                    "master","xxxxxxxx","doctor","dave","japan","michael","money","gateway","eagle1","naked","football","phoenix","gators","11111","squirt",
                    "shadow","mickey","angel","mother","stars","monkey","bailey","junior","nathan","apple","abc123","knight","thx1138","raiders","alexis","pass",
                    "iceman","porno","steve","aaaa","fuckme","tigers","badboy","forever","bonnie","6969","purple","debbie","angela","peaches","jordan","andrea",
                    "spider","viper","jasmine","harley","horny","melissa","ou812","kevin","ranger","dakota","booger","jake","matt","iwantu","aaaaaa","1212",
                    "lovers","qwertyui","jennifer","player","flyers","suckit","danielle","hunter","sunshine","fish","gregory","beaver","fuck","morgan","porn",
                    "buddy","4321","2000","starwars","matrix","whatever","4128","test","boomer","teens","young","runner","batman","cowboys","scooby","nicholas",
                    "swimming","trustno1","edward","jason","lucky","dolphin","thomas","charles","walter","helpme","gordon","tigger","girls","cumshot","jackie",
                    "casper","robert","booboo","boston","monica","stupid","access","coffee","braves","midnight","shit","love","xxxxxx","yankee","college",
                    "saturn","buster","bulldog","lover","baby","gemini","1234567","ncc1701","barney","cunt","apples","soccer","rabbit","victor","brian","august",
                    "hockey","peanut","tucker","mark","3333","killer","john","princess","startrek","canada","george","johnny","mercedes","sierra","blazer","sexy",
                    "gandalf","5150","leather","cumming","andrew","spanky","doggie","232323","hunting","charlie","winter","zzzzzz","4444","kitty","superman",
                    "brandy","gunner","beavis","rainbow","asshole","compaq","horney","bigcock","112233","fuckyou","carlos","bubba","happy","arthur","dallas",
                    "tennis","2112","sophie","cream","jessica","james","fred","ladies","calvin","panties","mike","johnson","naughty","shaved","pepper","brandon",
                    "xxxxx","giants","surfer","1111","fender","tits","booty","samson","austin","anthony","member","blonde","kelly","william","blowme","boobs","fucked",
                    "paul","daniel","ferrari","donald","golden","mine","golfer","cookie","bigdaddy","0","king","summer","chicken","bronco","fire","racing","heather",
                    "maverick","penis","sandra","5555","hammer","chicago","voyager","pookie","eagle","yankees","joseph","rangers","packers","hentai","joshua","diablo",
                    "birdie","einstein","newyork","maggie","sexsex","trouble","dolphins","little","biteme","hardcore","white","0","redwings","enter","666666","topgun",
                    "chevy","smith","ashley","willie","bigtits","winston","sticky","thunder","welcome","bitches","warrior","cocacola","cowboy","chris","green","sammy",
                    "animal","silver","panther","super","slut","broncos","richard","yamaha","qazwsx","8675309","private","fucker","justin","magic","zxcvbnm","skippy",
                    "orange","banana","lakers","nipples","marvin","merlin","driver","rachel","power","blondes","michelle","marine","slayer","victoria","enjoy","corvette",
                    "angels","scott","asdfgh","girl","bigdog","fishing","2222","vagina","apollo","cheese","david","asdf","toyota","parker","matthew","maddog","video",
                    "travis","qwert","121212","hooters","london","hotdog","time","patrick","wilson","7777","paris","sydney","martin","butthead","marlboro","rock",
                    "women","freedom","dennis","srinivas","xxxx","voodoo","ginger","fucking","internet","extreme","magnum","blowjob","captain","action","redskins",
                    "juice","nicole","bigdick","carter","erotic","abgrtyu","sparky","chester","jasper","dirty","777777","yellow","smokey","monster","ford","dreams",
                    "camaro","xavier","teresa","freddy","maxwell","secret","steven","jeremy","arsenal","music","dick","viking","11111111","access14","rush2112",
                    "falcon","snoopy","bill","wolf","russia","taylor","blue","crystal","nipple","scorpion","111111","eagles","peter","iloveyou","rebecca","131313",
                    "winner","pussies","alex","tester","123123","samantha","cock","florida","mistress","bitch","house","beer","eric","phantom","hello","miller",
                    "rocket","legend","billy","scooter","flower","theman","movie","6666","0","please","jack","oliver","success","albert","azerty","azerazer",
                    "rezareza");

if(isFormKeyValid() && !empty($_POST['name']) && !empty($_POST['mail'])
    && strlen($_POST['mail']) < 256 && strlen($_POST['password']) < 256 && strlen($_POST['name']) < 256
    && strlen($_POST['mail']) > 6 && strlen($_POST['password']) > 2 && strlen($_POST['name']) > 2 
    && !empty($_POST['password']) && !empty($_POST['password2']))
{
    if($_POST['password'] != $_POST['password2']) $signupError[] = lg('Password and its confirmation does not match');
    else 
    {
        $name = $db->real_escape_string(cleanUserName($_POST['name']));
        $mailHash = md5($db->real_escape_string(cleanUserMail($_POST['mail'])));
        $pass = $db->real_escape_string(hashPassword($_POST['password']));

        $user = $db->query("SELECT * FROM users WHERE name='".$name."'");
        if($user->num_rows > 0) $signupError[] = lg('This name is already used by another user');

        $user = $db->query("SELECT * FROM users WHERE mailHash='".$mailHash."'");
        if($user->num_rows > 0) $signupError[] = lg('This email is already used by another user');

        if(sizeof($signupError) == 0)
        {
            if($db->query("INSERT INTO users (name,mailHash,pass,session,karma) VALUES ('".$name."','".$mailHash."','".$pass."','',20)"))
            {
                $newId     = $db->insert_id;
                $sessionId = generateSessionId($newId);

                if($db->query("UPDATE users SET session='".$sessionId."' WHERE id=".$newId." LIMIT 1"))
                {
                    sendSessionCookie($sessionId);
                    redirectTo('.');
                }
            }
        }
    }
}

$html = ((sizeof($signupError) > 0)?'<p class=warning>'.implode('. ',$signupError).'</p>' : '')
        .'<form action=signup method=post>'
        .'<input type=text name=name maxlength=20 pattern="\w{2,25}"'.(empty($_POST['name'])? '' : ' value="'.$_POST['name'].'"').' placeholder="'.lg('User name').'" required autofocus title="'.lg('JUSTLOWERCASE').'">'
        .'<input type=email name=mail maxlength=255'.(empty($_POST['mail'])? '' : ' value="'.$_POST['mail'].'"').' placeholder="'.lg('Email').'" required>'
        .'<input type=password name=password maxlength=255 placeholder="'.lg('Password').'" required>'
        .'<input type=password name=password2 maxlength=255 placeholder="'.lg('CONFIRMPASSWORD').'" required>'
        .'<input type=submit value="'.lg('Sign up').'" class="btn green">'
        .generateFormKey()
        .'<h3>&nbsp;</h3>'
        .'<ul>'
        .'<li>'.lg('You will start with 20 karma points, you may bet with it').'</li>'
        .'<li>'.lg('Just lowercase letters for your username').'</li>'
        .'<li>'.lg('Your email will stay confidential, no jokes').'</li>'
        .'<li>'.lg('Choose a long and unique password').'</li>'
        .'<li>'.lg('We use Gravatar as your icon').'</li>'
        .'</ul>'
        .'</form>';

sendPageToClient(lg('Signup'),'<h1>'.lg('Signup').'</h1>'.$html);
?>