<?php

// Identifiants pour la base de données. Nécessaires pour la class BDD.
define('SQL_DSN',      'mysql:dbname=pitouli001;host=mysql5-20.perso');
define('SQL_USERNAME_ADMIN', 'pitouli001'); // Connexion avec droits de UPDATE, SELECT, INSERT, DELETE
define('SQL_PASSWORD_ADMIN', 'Pitouli91');
define('SQL_USERNAME_PUBLIC', 'pitouli001'); // Connexion avec droits de SELECT
define('SQL_PASSWORD_PUBLIC', 'Pitouli91');

// Identifiants pour le ftp. Nécessaire pour les indications de la zone d'administration.
define('FTP_HOST',      'ftp.pitouli.fr');
define('FTP_USERNAME', 'pitouli');
define('FTP_PASSWORD', '********');

// Identifiants pour webcron. Nécessaires pour la class WebcronAPI.
define('WEBCRON_USERNAME', '966332d413f8eb10');
define('WEBCRON_PASSWORD', 'bb8d1f280abd3939');

// Identifiants pour GoogleAnalytic. Nécessaires pour la class Gapi.
define('GA_EMAIL', 'analytics@pitouli.fr');
define('GA_PASSWORD', '15s6sAcs5PfyG56DsseR7d');
define('GA_SITE', 37148907);
define('GA_ACCOUNT', 'UA-18725578-1'); // pour le tracker javascript

// Clé pour repatcha. Nécessaire pour éviter le téléchargement abusif des photos
define('RECAPTCHA_PUBLIC_KEY', '6LdST80SAAAAAP70iwYIQ0-mOmbY4T9SYwMIK-TG');
define('RECAPTCHA_PRIVATE_KEY', '6LdST80SAAAAAD3t1DdVRRP8u5NXL13fd07vmGGp');

// Code de vérifications pour Google Webmaster Tools
define('GGL_SITE_VERIF', '9dZvaGbUie-16BMlTfbDkeb7uUXee3wSs4LSBWMTUa4');

// Chemins à utiliser
define('DIR_MODEL', 'model/');
define('DIR_CLASS', 'class/');
define('DIR_VIEW', 'view/');
define('DIR_INC', 'inc/');
define('DIR_FCT', 'fct/');
define('DIR_STYLE', 'style/');
define('DIR_ERRORS', 'errors/'); 
define('DIR_CONTROLLER', 'controller/');
define('DIR_PHOTOS', 'photos/');
define('DIR_PHOTOS_HD', 'photos/hd/');
define('DIR_PHOTOS_SD', 'photos/sd/');
define('DIR_PHOTOS_MIN', 'photos/min/');
define('DIR_ATTACHMENTS', 'photos/attachments/');
define('DIR_CACHE_PAGES_GALLERY', 'cache/gallery/');
define('DIR_CACHE_CSS', 'cache/css/');
define('DIR_CACHE_PHOTOS_HD', 'cache/photosHD/');
define('SITE_DOMAIN', 'http://jcp.pitouli.fr');
define('ROOT', '/');
define('BLOG',ROOT.'blog/');

// Constantes textuelles
define('SITE_TITLE', 'Galerie par JB Degiovanni');
define('BROWSER_SITE_TITLE', 'jcp.pitouli.fr');
define('SITE_DESCRIPTION', "Site de test du système de galerie photo créé par Jean-Baptiste Degiovanni.<p></p>Il permet d'importer des dizaines de milliers de photos en seulement 2 clics !</p><p>Un exemple fonctionnel :<br /><a href=\"http://www.pompanon.fr\" title=\"Galerie du père Pompanon\">Terre de Dieu, terres des hommes, Pompanon.fr</a>");
define('SITE_FOOTER', 'Cette galerie est utilisée uniquement à titre de démonstration - Une réalisation JB Degiovanni');

// Paramètres par défaut
//define('NB_PICT_PAGE', 20);
define('GAL_MIN_SIZE', 200);
define('GAL_MIN_SHADOW', 1);
define('GAL_MIN_ROUNDED', 1);

define('CSS_VERSION', 4); 

// Taille/poids des versions SD et miniatures des images
define('PICT_SD_MAX_LENGHT', 1600);
define('PICT_SD_QUALITY', 45);
define('PICT_MIN_LENGHT', 200);
define('PICT_MIN_QUALITY', 50);
define('PICT_HD_WATERMARKED_QUALITY', 90);
define('PICT_MIN_FORMAT', 'ratio'); // default : miniature carrée ; ratio : miniature qui respecte le ratio et qui tienne dans un carré de x pixels

// Importation des photos
$ext_photo = array('.jpg', '.jpeg'); // Les extensions autorisées pour les images
$ext_attachment =  array('.doc', '.docx', '.pdf', '.txt', '.mp3', '.ogg', '.wma', '.mov', '.wmv', '.mp4', '.avi'); // Les extensions autorisées pour les "pièces jointes"
define('DIR_IMPORT', 'import/'); // Le nom du dossier dans lequel se déroule le scan
define('DIR_STOCKAGE', 'photos/stockage/'); // Le nom du dossier dans lequel doivent être déplacer les photo importées en attente d'inclusion dans la galerie
define('MAX_UPLOAD_SIZE_MO', 50); // La taille maximum d'upload en Mo.
define('MAX_UPLOAD_SIZE_OCTET', MAX_UPLOAD_SIZE_MO * 000000); // La taille maximum d'upload en octets.
define('WATERMARK_SD', 'style/images/watermark_sd.png'); // L'adresse de l'image qui va taguer les photos SD
define('WATERMARK_HD', 'style/images/watermark_hd.png'); // L'adresse de l'image qui va taguer les photos HD
define('WATERMARK_HD_LOGO', 'style/images/watermark_hd_logo.png'); // L'adresse de l'image qui va taguer les photos HD (logo)

// Cron
define('CRON_MAX_TIME', 15); // Le temps maximum en seconde que peut prendre un script cron pour s'executer

// Gestion du cache
define('CACHE_ENABLED', false);