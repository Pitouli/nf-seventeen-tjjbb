<?php

// Identifiants pour la base de données. Nécessaires pour la class BDD.
define('SQL_DSN', 'pgsql:dbname=dbnf17p095;host=tuxa.sme.utc;port=5432');
define('SQL_USERNAME_ADMIN', 'nf17p095'); // Connexion avec droits de UPDATE, SELECT, INSERT, DELETE
define('SQL_PASSWORD_ADMIN', 'gubeL3AB');
define('SQL_USERNAME_PUBLIC', 'nf17p095'); // Connexion avec droits de SELECT
define('SQL_PASSWORD_PUBLIC', 'gubeL3AB');

// Chemins à utiliser
define('DIR_MODEL', 'model/');
define('DIR_CLASS', 'class/');
define('DIR_VIEW', 'view/');
define('DIR_INC', 'inc/');
define('DIR_FCT', 'fct/');
define('DIR_STYLE', 'style/');
define('DIR_ERRORS', 'errors/'); 
define('DIR_CONTROLLER', 'controller/');
define('SITE_DOMAIN', 'http://tuxa.sme.utc');
define('ROOT', '/~nf17p095/');

// Constantes textuelles
define('SITE_TITLE', 'Faisons voler les avions');
define('BROWSER_SITE_TITLE', 'Avions NF17');
define('SITE_DESCRIPTION', "Site de test du système de galerie photo créé par Jean-Baptiste Degiovanni.<p></p>Il permet d'importer des dizaines de milliers de photos en seulement 2 clics !</p><p>Un exemple fonctionnel :<br /><a href=\"http://www.pompanon.fr\" title=\"Galerie du père Pompanon\">Terre de Dieu, terres des hommes, Pompanon.fr</a>");
define('SITE_FOOTER', 'Cette galerie est utilisée uniquement à titre de démonstration - Une réalisation JB Degiovanni');