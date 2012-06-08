<?php

//////////////////////////////////////////////////////////////////////////////////////////
//					 NOMBRE DE FICHIERS DANS LE DOSSIER IMPORT							//
//////////////////////////////////////////////////////////////////////////////////////////

// fct jumelle dans admin.default.model.php
function countFiles($directory, $nb_files=0) {
	$directory = realpath($directory);
	$d = dir($directory);
	while (false !== ($file = $d->read())) { // Tant qu'il y a des fichiers
		if (is_dir(realpath($directory . '/' . $file))) { // Si le fichier est un dossier
			if ($file != '.' && $file != '..') { // Si ce n'est pas un élément de navigation		
				$nb_files = countFiles($directory . '/' . $file, $nb_files); // On réexecute le comptage pour ce dossier
			}
		}
		else { // Si le fichier n'est pas un dossier
			$nb_files++; // On le compte
		}
	}
	return $nb_files;
}

// On compte le nombre de fichiers dans le dossier d'importation
$nb_files = countFiles(DIR_IMPORT);

//////////////////////////////////////////////////////////////////////////////////////////
//							LISTE DES ALBUMS EXISTANTS									//
//////////////////////////////////////////////////////////////////////////////////////////

function createTree($albums, $indent_pattern = '&nbsp;-&nbsp;', $id_parent=0, $rank=0, $indent = NULL, $forbid_id = NULL, $listSelectOptionAlbum = NULL) {
	foreach ($albums as $key => $alb) { // Pour tous les albums
		if($alb['id_parent'] == $id_parent AND $alb['id'] != $forbid_id) { // Si l'album est un fils de l'album pour qui on les recherches	
			$listSelectOptionAlbum .= '<option value="'.$alb['id'].'">'.$indent.'|&nbsp;'.utf8_encode($alb['title']).'</option>'; // On affiche le fils
			unset($albums[$key]); // On supprime l'album de l'array pour accélerer la recherche
			$listSelectOptionAlbum = createTree($albums, $indent_pattern, $alb['id'], $rank+1, $indent.$indent_pattern, $forbid_id, $listSelectOptionAlbum); // Et on recherches ses propres fils
		}
	}
	return $listSelectOptionAlbum;
}

$sql = "SELECT id, id_parent, title FROM albums ORDER BY title ASC";
$result = $bdd->query($sql);
$albums = $result->fetchAll();

$listSelectOptionAlbum = createTree($albums);

//////////////////////////////////////////////////////////////////////////////////////////
//									LISTE DES PRIX										//
//////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM prices";
$result = $bdd->query($sql);
$prices = $result->fetchAll();

$listSelectOptionPrices = NULL;

foreach($prices as $price) {
	$listSelectOptionPrices .= '<option value="'.$price['id'].'">'.$price['title'].'</option>';
}

//////////////////////////////////////////////////////////////////////////////////////////
//							LISTE DES DOSSIERS DANS IMPORT								//
//////////////////////////////////////////////////////////////////////////////////////////

// Fonction qui récupère la structure d'un dossier
function scanStruct($directory, $sub_folders = false, $indent = '', $indent_pattern = '&nbsp;-&nbsp;', $array = array())
{
	$directory = realpath($directory);
	$d = dir($directory);
	
	// Tant qu'il y a des fichiers
	while (false !== ($file = $d->read()))
	{
		// Si le fichier est un dossier
		if (is_dir(realpath($directory . '/' . $file)))
		{
			// Si ce n'est pas un élément de navigation
			if ($file != '.' && $file != '..')
			{			
				$folder['title'] = $file;
				$folder['indent'] = $indent;
				$array[] = $folder;

				// Si on scan aussi les sous dossier
				if($sub_folders)
				{
					// On réexecute la collecte pour ce dossier
					$array = scanStruct($directory . '/' . $file, $sub_folders, $indent.$indent_pattern, $indent_pattern, $array);
				}
			}
		}
	}

	return $array;
}

$foldersInImport = scanStruct(DIR_IMPORT);

if(!empty($foldersInImport))
{
	$foldersInImportJsAlert = 'Dossiers contenus dans le dossier IMPORT :';
	
	foreach($foldersInImport as $fold)
	{
		$foldersInImportJsAlert .= '\n'.$fold['indent'].'&nbsp;|&nbsp;'.addslashes($fold['title']);
	}
}
else
{
	$foldersInImportJsAlert = addslashes('Le dossier IMPORT ne contient aucun dossier. Si le dossier IMPORT n\'est pas vide, c\'est qu\'il contient lui même les fichiers.');
}
