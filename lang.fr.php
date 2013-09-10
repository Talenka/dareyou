<?php
/**
 * Language file for french
 */

namespace Dareyou;

global $sentences;

$sentences = array(
'dateFormat' => 'j/m/Y à G\hi',
'by' => 'par',
'Welcome' => 'Bienvenue',
'Français' => 'Français',
'English' => 'Anglais',
'Signup' => 'Inscription',
'Sign up' => 'S’inscrire',
'Dare to sign up' => 'Osez vous inscrire',
'Login' => 'Connexion',
'Log in' => 'Se connecter',
'Log out' => 'Déconnexion',
'From' => 'De',
'to' => 'à',
'referee' => 'arbitre',
'referees' => 'arbitres',
'User name or email' => 'Pseudo ou email',
'Password' => 'Mot de passe',

'User name' => 'Pseudonyme',
'Email' => 'Email',
'Notes' => 'Notes',
'About' => 'À propos',

'Lost password' => 'Mot de passe oublié',
'What are you gonna do awesome today?' => 'Qu’allez-vous faire de génial aujourd’hui ?',
'Last completed challenges' => 'Derniers défis relevés',
'New challenges' => 'Nouveaux défis',
'Greatest challenges' => 'Les plus grands défis',
'Challenge' => 'Défi',
'out of' => 'sur',
'won' => 'gagné',
'issued' => 'lancé',
'Some figures' => 'Quelques chiffres',
'Players' => 'Joueurs',
'Challenges' => 'Défis',
'Attempts' => 'Tentatives',
'% successful' => '% de réussite',
'Comments' => 'Commentaires',
'and' => 'et',
'Bets' => 'Paris',
'Time to complete the challenge:' => 'Temps pour réussir le défi :',
'Bettors have wagered a total of ' => 'Les parieurs ont misés un total de ',
'on this challenge' => 'sur ce défi',
'days' => 'jours',
'You have been logged out. Goodbye !' => 'Vous êtes déconnecté, au revoir !',
'Hello again' => 'Re-bonjour',
'Start a challenge' => 'Lancer un défi',

// error.php

'ERRMSG' => 'Oups, une erreur s’est produite !',
'Try to go back to' => 'Essayez de revenir à',
'the previous page' => 'la page précédente',
'or return to' => 'ou retournez à',
'the homepage' => 'la page d’accueil',
'If the problem persists, do not hesitate' => 'Si le problème persiste, n’hésitez pas à',
'to contact us' => 'nous contacter',

// signup.php

'Just lowercase letters for your username' => 'Votre pseudo en lettres minuscules svp',
'Your email will stay confidential, no jokes' => 'Votre email restera confidentiel, juré',
'Choose a long and unique password' => 'Choisissez un mot de passe long et unique',

'You will start with 20 karma points, you may bet with it' =>
    'Vous démarrez avec 20 points de karma, avec lesquels vous pourrez parier.',

'We use Gravatar as your icon' =>
    'Votre email + <a href="//gravatar.com">Gravatar</a> = votre avatar',

'CONFIRMPASSWORD' => 'Confirmez votre mot de passe',

'This password is too common, please choose another' =>
    'Ce mot de passe est trop courant, choisissez-en un autre svp',

// login.php

'Email or password is incorrect, please retry' =>
    'Email ou mot de passe incorrect, essayez à nouveau',
'In other languages'=> 'Dans d’autres langues',
'Frequently Asked Questions' => 'Questions fréquemment posées',
'You need to sign up to fully enjoy the site, but it is done in a wink.' =>
    'Vous devez vous inscrire pour profiter pleinement du site, mais ça se fait en un clin d’oeil.',

'Have you lost your password ?' => 'Mot de passe perdu ?',
'Hey it seems you are already logged in' => 'Il semble que vous êtes déjà connecté',
'Don’t you seek rather to log out?' => 'Ne cherchez-vous pas plutôt à vous déconnecter ?',
'To protect your privacy, you should use the encrypted version of this website' =>
    'Afin de protéger votre vie privée, vous devriez utiliser la version cryptée de ce site',

// about.php

'How it works' => 'Comment ça marche',
'How it works ...' => 'Dareyou permet à tous de lancer des défis amusants à ' .
    'ses amis ou à tous les internautes, qui peuvent miser ou directement ' .
    'participer au défi. Les participants doivent envoyer une preuve qu’ils ' .
    'ont réussi le défi, par exemple une photo ou une vidéo (qui peuvent être' .
    ' hébergées sur d’autres site).<br><br>Les arbitres, choisis au hasard, ' .
    'désignent alors les vainqueurs. Les gagnants reçoivent des points de ' .
    'karma, plus éventuellement d’autres récompenses précisées dans le ' .
    'pari/défi. Les perdants perdent des points de karma, et doivent ' .
    'éventuellement s’acquitter d’une tâche ingratte spécifier dans le défi.',

'Under the hood' => 'Sous le capot',
' is a project of ' => ' est un projet de ',
'published under the GPL3+ licence' => 'publié sous licence GNU GPL',
'freely available on Github' => 'disponible librement sur Github',

// start-challenge.php

'The challenge title (simple and unique)' => 'L‘intitulé du défi (simple et unique)',
'Challenge description with details' => 'Description détaillée du défi',
'Time to accomplish the challenge (in days)' => 'Temps pour réaliser le défi (en jours)',
'Challenge image URL like http://...' => 'URL de l’image du défi http://...',
'You have not given a challenge title' => 'Vous n’avez pas donné de titre au défi',
'Your title is too short (3 letters minimum)' => 'Le titre est trop court (3 lettres minimum)',
'Your title is too long (255 letters minimum)' => 'Le titre est trop long (255 lettres maximum)',
'Your description is too long (65535 letters maximum)' => 'La description est trop longue (65535 caractères max)',
'It takes at least 1 day to complete the challenge' => 'Cela prend au moins 1 jour pour réaliser le défi',
'Your image URL is too long (255 characters maximum)' =>
    'L’URL de votre image est trop longue (255 caractères maximum)',
'There are some errors that prevent starting the challenge:' => 'Quelques erreurs empêchent de lancer le défi :',
'Public profile' => 'Profil public',

// faq.php

'Contact us' => 'Contactez-nous',
'My data will remain confidential?' => 'Mes données resteront-elles confidentielles ?',
'YOURDATASTAYCONFIDENTIAL' => 'La seule donnée personnelle dont nous avons connaissance est votre pseudo. Votre email' .
    ' n’est sauvegardé dans notre base de données que sous une forme (md5) qui rend très difficile sont décodage. De ' .
    'la même manière, votre mot de passe est en sureté grâce à un hachage SHA512 bien salé.',

'Can I buy karma points?' => 'Peut-on acheter des points de karma ?',
'NOYOUCANTBUYKARMA' => 'Non, pas pour le moment. Le karma est relativement sacré. Si le site devient suffisament ' .
    'populaire et que la guilde des druides de Cournouailles nous donne son accord, nous ouvrirons un compte Paypal, ' .
    'probablement...',

'How to earn karma points?' => 'Comment gagner des points de karma ?',
'EARNKARMABYPLAYING' => 'Vous pouvez gagner des points de karma (♣) soit en réalisant des défis, soit en pariant sur ' .
    'le fait qu’un joueur va ou non réaliser un défi. Vous pouvez parier sur vous-même, bien entendu. Si vous ' .
    'réalisez un défi, vous gagnez la moitié des sommes misées pour ou contre vous, plus 10% du total des sommes ' .
    'misées sur ce défi. Si un joueur gagne un défi, tous les parieurs qui avait misé contre lui perdent leur  mise. ' .
    'Le montant ainsi récolté est divisé entre les parieurs qui avait misé sur le joueur. Si le joueur perd le défi, ' .
    'c’est le contraire qui se produit.',

'Who decides that a player has won a challenge?' => 'Qui décide qu’un joueur a gagné un défi ?',
'REFEREESDECIDE' => 'Des arbitres sont tirés au hasard parmis les meilleurs joueurs (plus vous avez un karma élevé, ' .
    'plus vous avez de chance d’arbitrer un défi). L’arbitre regarde la ou les preuves que le joueur a envoyé, et ' .
    'juge si le défi est bien gagné et si bien le  joueur qu’il l’a gagné. Un arbitre a 48h pour rendre sa décision, ' .
    'sinon un autre arbitre choisi. L’arbitre gagne 5 ♣ par décision rendue. Le nombre d’arbitres nécessaire pour ' .
    'valider un défi dépend des sommes misées sur le défi :',

'I cannot use Internet Explorer here, why?' =>
    'Pourquoi ne puis-je utiliser Internet Explorer ici ?',
'IE is a mess' =>
    'Internet Explorer est un navigateur mal conçu, peu respectueux des standards de l’Internet et de votre vie ' .
    'privée. Rendez-vous service, <b><a href=//www.mozilla.org>utilisez Firefox</a></b> à la place',

// edit-profile.php

'Edit my profile' => 'Modifier mon profil',

// admin*.php

'Logs' => 'Registres',
'Users' => 'Utilisateurs',
'Operations' => 'Opérations',

// search.php

'There is nothing like this here, sorry' => 'Il n’y a rien de tel ici, désolé',

// challenge.php

'Language:' => 'Langue :',
'the adventure' => 'l’aventure',
'One people has tried' => 'Une personne a tenté',
'No one has tried' => 'Personne n’a encore tenté',
'people have tried' => 'personnes ont tenté',
'One comment' => 'Un commentaire',

);
