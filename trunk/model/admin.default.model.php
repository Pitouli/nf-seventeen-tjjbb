<?php

// NB DE PHOTOS / PIECES JOINTES / ALBUMS

$photosTotal = $bdd->getNbRow("photos", "1=1");
$photosVisible = $bdd->getNbRow("photos", "status='visible'");
$photosHide = $bdd->getNbRow("photos", "status='hide'");
$photosStock = $bdd->getNbRow("photos", "status='stock' OR status='regeMinVisible' OR status='regeMinHide' OR status='regeMin2suppr'");
$photos2Suppr = $bdd->getNbRow("photos", "status='2suppr'");
$photosOther = $photosTotal-$photosVisible-$photosHide-$photosStock-$photos2Suppr;

$attchmtTotal = $bdd->getNbRow("attachments", "1=1");
$attchmtVisible = $bdd->getNbRow("attachments", "status='visible'");
$attchmtHide = $bdd->getNbRow("attachments", "status='hide'");
$attchmt2Suppr = $bdd->getNbRow("attachments", "status='2suppr'");
$attchmtOther = $attchmtTotal-$attchmtVisible-$attchmtHide-$attchmt2Suppr;

$albumsTotal = $bdd->getNbRow("albums", "1=1");
$albumsVisible = $bdd->getNbRow("albums", "hide=0");
$albumsHide = $albumsTotal-$albumsVisible;

// CREDIT WEBCRON RESTANT

$webcron = new WebcronAPI;
$credits = $webcron->getCredits();

// NOMBRE FICHIERS DANS DOSSIER IMPORT

// fct jumelle dans admin.import.model.php
function countFiles($directory) {
	global $nb_files; // On declare comme globale la variable qui va compter les fichiers
	$directory = realpath($directory);
	$d = dir($directory);
	while (false !== ($file = $d->read())) { // Tant qu'il y a des fichiers
		if (is_dir(realpath($directory . '/' . $file))) { // Si le fichier est un dossier
			if ($file != '.' && $file != '..') { // Si ce n'est pas un élément de navigation		
				countFiles($directory . '/' . $file); // On réexecute le comptage pour ce dossier
			}
		}
		else { // Si le fichier n'est pas un dossier
			$nb_files++; // On le compte
		}
	}
}
$nb_files = 0; // la variable qui va être mise à jour par la fonction
countFiles(DIR_IMPORT);