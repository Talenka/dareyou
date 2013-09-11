<?php
/**
 * Language file for english
 *
 * As this is the default language, only special phrases are listed here,
 * because others phrases do not need to be translated.
 */

namespace Dareyou;

global $sentences;

$sentences = array(

    'dateFormat' => 'F jS, Y \a\t g:ia',
    'Français' => 'French',

    // error.php

    'ERRMSG' => 'Oups, something wrong happen!',

    // signup.php

    'CONFIRMPASSWORD' => 'Confirm your password',

    'We use Gravatar as your icon' =>
        'Your email + <a href="//gravatar.com">Gravatar</a> = your avatar',

    // about.php

    'How it works ...'  => 'Dareyou lets everyone launch fun challenges to his ' .
        'friends or all web users who may bet or directly participate in the ' .
        'challenge. Participants must submit proof that they have completed the ' .
        'challenge, such as a photo or video (which may be hosted on other site).' .
        '<br><br>Referees, randomly chosen, then designate the winners. Winners ' .
        'receive karma points, plus any other rewards specified in the bet / ' .
        'challenge. The losers lose karma points, and may need to perform a task ' .
        'ingratte specified in the challenge.',

    // faq.php

    'IE is a mess' => 'Internet Explorer is a poorly designed browser, with ' .
        'little respect for the Internet standards and for your privacy. Do ' .
        'yourself a favor, <b><a href=//www.mozilla.org>use Firefox</a></b> instead',

    'NOYOUCANTBUYKARMA' => 'No, not yet. Karma is fairly sacred. If this site ' .
        'becomes popular enough and if the Cournouailles druids guild gives us ' .
        'permission, we will open a Paypal account, probably ...',

    'YOURDATASTAYCONFIDENTIAL' => 'The only personal data that we know is your ' .
        'nickname. Your email is saved in our database in a form (MD5) that makes ' .
        'decoding very difficult. Similarly, your password is secure thanks to a ' .
        'well salted SHA512 hash.',

    'REFEREESDECIDE' => 'Referees are randomly chosen among the best players (the higher your ' .
        'karma is, the greater your chance to referee a challenge). The referee ' .
        'watches evidence(s) that the player has sent, and judges whether the ' .
        'challenge is completed and so the player he has won, or not. An referee ' .
        'has 48 hours to make a decision, otherwise another referee is picked. ' .
        'The referee gets 5 ♣ by decision. The number of arbitrators needed to ' .
        'validate a challenge depends on the amount wagered on the challenge:',

    'EARNKARMABYPLAYING' => 'You can earn karma points (♣) either by completing ' .
        'challenges, or by betting on the fact that a player will or will not ' .
        'complete a challenge. You can bet on yourself, of course. If you complete ' .
        'a challenge, you win half wagers for or against you, plus 10% of the ' .
        'total amount wagered on this challenge. If a player completes a challenge, ' .
        'all the bettors who had bet against him lose their bet. The amount thus ' .
        'collected is divided between bettors who wagered on the player. If the ' .
        'player loses the challenge, the opposite happens.');
