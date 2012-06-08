<?php

// Album à regarder
if($_GET['section'] == 'selection') // Si on est dans l'album virtuel "selection"
{
	require DIR_MODEL.'gallery.selection.model.php';
	require DIR_VIEW.'gallery.view.php';
}
else // On n'est dans un album classique
{
	$currentAlbum = ($_GET['section'] == NULL OR $_GET['section'] == 'index') ? 1 : $_GET['section'];

	if($currentAlbum == 'selection')
	{
		require DIR_MODEL.'gallery.selection.model.php';
		require DIR_VIEW.'gallery.view.php';		
	}
	else
	{
		$cacheAlbumFile = DIR_CACHE_PAGES_GALLERY.$currentAlbum.'.album';
	
		if(is_file($cacheAlbumFile) && CACHE_ENABLED) // Si le fichier de cache existe
		{	
			$cacheAlbumHTML = file_get_contents($cacheAlbumFile);
			echo $cacheAlbumHTML; // On affiche le contenu du fichier
		}
		else // Sinon
		{	
			// On met le contenu de la page dans un tampon
			
			ob_start();
			
			require DIR_MODEL.'gallery.model.php';
			require DIR_VIEW.'gallery.view.php';
			
			$pageAlbumHTML = ob_get_flush(); // On récupère le contenu du tampon (et on vide le tampon)
			
			file_put_contents($cacheAlbumFile, $pageAlbumHTML); // On crée le fichier de cache contenant la sortie du tampon
		}	
	}
	
}