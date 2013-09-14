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
4. Make sure you have write access to cache directory (`c`).

### Under the hood

Like this is an exercise, here are the guidelines I set for myself:

* Best practices:
    * Complete, concise, public, up-to-date [documentation](http://dareyou.be/doc/) 
      (with [phpdoc](https://github.com/phpDocumentor/phpDocumentor2))
    * Follow the [coding style standards](https://github.com/php-fig/fig-standards/)
      (with [php_cs_fixer](https://github.com/fabpot/PHP-CS-Fixer))
    * [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) code
      (with [phpmd](https://github.com/phpmd/phpmd))
    * [Semantic](https://en.wikipedia.org/wiki/Semantic_HTML),
      [responsive](https://en.wikipedia.org/wiki/Responsive_Web_Design),
      [progressively enhanced](https://en.wikipedia.org/wiki/Progressive_Enhancement) HTML5
    * [Cool URLs](http://www.w3.org/Provider/Style/URI)
    * [Obsessive minification](https://en.wikipedia.org/wiki/Minification_%28programming%29)
* For fun:
    * One view to rule them
    * No javascript (pure HTML5 on client side)
    * No classes
      (purely functional [`core`](https://github.com/Talenka/dareyou/blob/master/core.php) 
      and purely procedural controllers)
