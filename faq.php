<?php

namespace Dareyou;

require_once 'core.php';

$pageTitle = L('Frequently Asked Questions');

$html = h1($pageTitle) .
        '<ul>'
            .'<li><a href=#ie>'.L('I cannot use Internet Explorer here, why ?').'</a></li>'
            .'<li><a href=#how-to-earn-karma>Comment gagner des points de karma ?</a></li>'
            .'<li><a href=#who-decide-who-win>Qui décide qu’un joueur à gagner un défi ?</a></li>'
            .'<li><a href=#how-to-buy-karma>Peut-on acheter des points de karma ?</a></li>'
            .'<li><a href=#privacy>Mes données resteront-elles confidentielles ?</a></li>'
        .'</ul>' .

        '<h2 id=ie>' . L('I cannot use Internet Explorer here, why ?').'</h2>' .
        '<p>' . L('IE is a mess') . '.</p>'

        .'<h2 id=how-to-earn-karma>Comment gagner des points de karma ?</h2>'
        .'<p align=justify>'
        .'Vous pouvez gagner des points de karma soit réalisant des défis, '
        .'soit en pariant sur le fait qu’un joueur va ou non réaliser un défi. '
        .'Vous pouvez parier sur vous-même, bien entendu. Si vous réalisez un '
        .'défi, vous gagnez la moitié des sommes misées pour ou contre vous, '
        .'plus 10% du total des sommes misées sur ce défi. Si un joueur gagne'
        .' un défi, tous les parieurs qui avait misé contre lui perdent leur '
        .' mise. Le montant ainsi récolté est divisé entre les parieurs qui '
        .'avait misé sur le joueur. Si le joueur perd le défi, c’est le '
        .'contraire qui se produit.</p>'

        .'<h2 id=who-decide-who-win>Qui décide qu’un joueur à gagner un défi ?</h2>'
        .'<p align=justify>Des arbitres sont tirés au hasard parmis les '
        .'meilleurs joueurs (plus vous avez un karma élevé, plus vous avez de '
        .'chance d’arbitrer un défi). L’arbitre regarde la ou les preuves que '
        .'le joueur a envoyé, et juge si le défi est bien gagné et si bien le '
        .'joueur qu’il l’a gagné. Un arbitre à 48h pour rendre sa décision, '
        .'sinon un autre arbitre choisi. L’arbitre 5 ♣ par décision rendue. Le '
        .'nombre d’arbitres nécessaire pour valider un défi dépend des sommes '
        .'misées sur le défi : </p>'
        .'<ul>'
            .'<li>De 1 à 10 ♣ : 1 arbitre</li>'
            .'<li>De 11 à 100 ♣ : 2 arbitres</li>'
            .'<li>De 101 à 1000 ♣ : 3 arbitres</li>'
            .'<li>De 1001 à 10000 ♣ : 4 arbitres</li>'
            .'<li>De 10001 à 100000 ♣ : 5 arbitres</li>'
            .'<li>etc...</li>'
        .'</ul>'

        .'<h2 id=how-to-buy-karma>Peut-on acheter des points de karma ?</h2>'
        .'<p align=justify>Non, pas pour le moment. Le karma est relativement '
        .'sacré. Si le site devient suffisament populaire et que la guilde des '
        .'druides de Cournouailles nous donne sont accord, nous ouvrirons un '
        .'compte Paypal, probablement...'

        .'<h2 id=privacy>Mes données resteront-elles confidentielles ?</h2>'
        .'<p align=justify>La seule donnée personnelle dont nous avons connaissance est votre pseudo. Votre email n’est sauvagardé dans notre base de données que sous une forme (md5) qui rend extrêmement difficile sont décodage. De la même manière, votre mot de passe est en sureté grâce à un hachage SHA512 bien salé.</p>';

sendPageToClient($pageTitle, $html);
