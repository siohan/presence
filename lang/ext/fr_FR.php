<?php
$lang['add'] = 'Ajouter ';
$lang['apply_to_selection'] = 'Appliquer à la sélection';
$lang['areyousure_actionmultiple'] = 'Etes-vous certain ?';
$lang['cancel'] = 'Annuler';
$lang['copy'] = 'Dupliquer';
$lang['delete'] = 'Supprimer';
$lang['edit'] = 'Modifier';
$lang['false'] = 'Faux';
$lang['filtres'] = 'Filtrez !';
$lang['friendlyname'] = 'Asso Présences';
$lang['groupassign'] = 'Créer une liste';
$lang['moddescription'] = 'Gestion des présents/absents.';
$lang['new'] = 'Nouveau';
$lang['postinstall'] = 'Merci d\'avoir installer ce module.';
$lang['postuninstall'] = 'Module désinstallé.';
$lang['really_uninstall'] = 'Etes-vous certain de vouloir désinstaller ce module ?';
$lang['resultsfoundtext'] = 'Résultats trouvés';
$lang['send'] = 'Envoi email';
$lang['submit'] = 'Envoyer';
$lang['submitasnew'] = 'Ajouter en tant que nouvelle équipe';
$lang['submitall'] = 'Tout sélectionner';
$lang['true'] = 'Vrai';
$lang['view'] = 'Voir';
$lang['welcome_text'] = '<p>Bienvenue dans le module de gestion des présences</p>';
//les bulles d'aide dans les formulaires
$lang['help_actif_inactif'] = 'Activez ou désactivez la présence. Si inactif, les réponses ne sont plus possibles.';
$lang['help_date_debut'] = 'Choisissez une date de début.';
$lang['help_date_limite'] = 'Indiquez une date limite. Passée cette date, vous ne pourrez plus envoyer des relances et les réponses seront impossibles.';
$lang['help_groupe_concerne'] = 'Choisissez le groupe qui va recevoir les questions.';
$lang['help_groupe_notifie'] = 'Choisissez le groupe à notifier. Ce groupe recevra les nouvelles réponses par email avec un lien vers la liste des réponses exhaustive et actualisée.';
$lang['help_alias'] = 'Renseignez l\'alias de la page dans laquelle vous avez placé la balise {cms_module module=Adherents}. Sinon vous ne pourrez pas collecter les réponses.';
$lang['help_description'] = 'Donnez une description courte utile pour votre tableau de bord.';
$lang['help_sujet_email'] = 'Modifier à l\'envi le sujet de l\'email ';
$lang['help_corps_email'] = 'Vous pouvez modifier le corps de \'email. Attention de conserver les variables{$titre}, {$lienok} et {$lienko}. Pour désactiver une balise : {*$description*}';
$lang['help_sms_sender'] = 'C\'est le nom qui apparaitra comme expéditeur du SMS. Choisissez un nom évocateur pour vos destinataires';
$lang['help_corps_sms'] = 'Un SMS contient 160 caractères. Attention à ce que les variables {$titre} et {$description} ne dépasse la limite. Attention de conserver les variables{$titre} et {$lienok}. Pour désactiver une balise : {*$description*}';

$lang['help'] = '<h3>Que fait ce module ?</h3>
<p>Ce module vous permet de gérer les absences/présences pour une manifestation, réunion, rencontres sportives, entrainements,etc sous la forme du nom (et description si vous le souhaitez) ceci appelée question ci-dessous.<br />
Dans cette version, vous créer votre question et l\'envoi se fait par mail et /ou par SMS.</p>
<h3>Installation</h3>
<p>Pour gérer les réponses, utilisez le tag suivant dans une de vos pages {cms_module module=Presence} et de renseigner l\'alias de cette page dans l\'onglet "Emails". Idéalement, utilisez un gabarit compatible avec les smartphones pour cette page.</p>
<h3>Groupes</h3>
<p>Les groupes utilisés sont ceux du module Adhérents (Asso Adhérents)</p>
<h3>Paramètres Bitly</h3>
<p>Bitly est un service tiers qui permet, entre autres, de raccourcir vos urls, ce qui est très utile pour twitter et bien entendu pour les SMS</p><p>Il vous faudra créer un compte bitly (<a href="https://app.bitly.com/" target="_blank">bit.ly</a>) pour pouvoir raccourcir les urls dans vos SMS et ne pas dépasser les 160 caractères</p> 
<h3>Notifications</h3>
<p>Le groupe concerné reçoit un mail ou un SMS pour répondre à votre question. Le système va vérifier s\'il y a eu un ajout ou une modification depuis un intervalle de temps que vous avez défini dans  l\'onglet "Notifications". S\'il y a eu des réponses, le système envoie un email au groupe à notifier avec les nouvelles réponses et un lien vers la liste exhaustive et actualisée des réponses.<br />
Pour collecter les réponses, le système utilise des tâches pseudo-cron qui dépendent de l\'activité du site. <br />Pour optimiser vos collectes, nous vous conseillons d\'utiliser des tâches cron via un service tiers (des gratuits existent et fonctionnent très bien).</p>
<h3>Relances</h3>
<p>Les relances sont manuelles (pour l\'instant).En cliquant sur les pictos Mail et SMS vous envoyez  (ou renvoyez) la question aux personnes n\'ayant pas répondu.</p>
<p><strong>Attention !</strong> Si la date limite de réponse est dépassée, si tout le monde a répondu ou si la question n\'est plus active, il n\'est plus possible de renvoyer la question ni de re recevoir des réponses de celle-ci.</p>
<h3>Corps du mail et du SMS</h3>
<p>Vous pouvez modifier le corps du mail suivant vos besoin. Il s\'agit d\'un mail au format html prévu pour s\'afficher sous forme de deux boutons. Pour le SMS, attention de bien respecter les 160 caractères sinon deux SMS seront envoyés.</p>
<h3>Fonctionnement optimal</h3>
<p>Asso Simple est une suite de modules conçue pour fonctionner en relation les uns avec les autres. Pour un fonctionnement optimal, vous devriez installer les autres modules de la suite. Renseignements sur www.agi-webconseil.fr/</p>
<h3>Bogues et Github</h3>
<p>Certaines corrections de bogues mineurs ne font pas l\'objet d\'une version officielle mais peuvent toutefois se trouver sur le github dont l\'adresse figure ci-dessous.<br />Il vous suffit alors de télécharger le fichier zip disponible(via le bouton vert "Clone or download") et de le déployer si votre serveur.</p>
<ul>
<li>Pour obtenir la dernière version en cours (avant release officielle)
<a href="https://github.com/siohan/presence">Version github</a>.</li>
</ul>
<p>En tant que licence GPL, ce module est livré tel quel. Merci de lire le texte complet de la license pour une information complête.</p>
<h3>Copyright et License</h3>
<p>Copyright &amp;copy; 2014, AssoSimple <a href="mailto:claude.siohan@gmail.com">claude.siohan@gmail.com</a>. Tous droits réservés.</p>
<p>Ce module est sous licence <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. Vous devez accepter la licence avant d\'utiliser ce module.</p>
<p>Ce module a été distribué dans l\'espoir d\'être utile, mais sans
AUCUNE GARANTIE. Il vous appartient de le tester avant toute mise en
production, que ce soit dans le cadre d\'une nouvelle installation ou
d\'une mise à jour du module. L\'auteur du module ne pourrait être tenu
pour responsable de tout dysfonctionnement du site provenant de ce
module. Pour plus d\'informations, <a
href=\"http://www.gnu.org/licenses/licenses.html#GPL\" target=\"_blank\">consultez
la licence GNU GPL</a>.</p>
';

?>