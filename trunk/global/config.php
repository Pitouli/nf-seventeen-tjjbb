<?php

require 'config_bdd.php';

// Variables pour la sécurité
define('PASSWORD', 'admin');
define('CONNECTION_TRY', 5); // Nb d'essai autorisés pour se connecter

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