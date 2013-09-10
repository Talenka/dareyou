**N.B.** : _This project is a joke, only for me to relax. But maybe one day it
will become legen... *wait for it* ...dairy !_

Dareyou lets everyone launch fun challenges to his friends or all web users who
may bet or directly participate in the challenge. Participants must submit proof
that they have completed the challenge, such as a photo or video (which may be
hosted on other site).

Referees, randomly chosen, then designate the winners. Winners receive karma
points, plus any other rewards specified in the bet / challenge. The losers
lose karma points, and may need to perform a task ingratte specified in the
challenge.

© [Boudah Talenka](http://boudah.pl) 2012, published under the
[GNU General Public Licence](http://www.gnu.org/licenses/gpl.html).

### Installation

0. Works with PHP 5.3 and MySql 5.1
1. Open [`config.sample.php`](https://github.com/Talenka/dareyou/blob/master/config.sample.php)
2. Modify it according to your MySql server, then rename it as `config.php`.
3. Load [`install.sql`](https://github.com/Talenka/dareyou/blob/master/install.sql) in your database.
4. Make sure you have write access to cache directory.

### Under the hood

The code is [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself),
[PSR](https://github.com/php-fig/fig-standards/) compliant,
concisely [documented](http://dareyou.be/doc/), but uses no class at all.
HTML and CSS are lovingly minified down to the last bit. No javascript needed!

Unlike most PHP projects, there is no one entry point. Instead, each file 
include the [`core.php`](https://github.com/Talenka/dareyou/blob/master/core.php). 
Each website page have its own file. All files are in the root folder. Why 
this ? Just for fun, and to see if it is a choice as bad as people say ;-)