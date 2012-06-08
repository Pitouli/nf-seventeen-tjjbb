<?php 

header("Content-type: text/css"); // On déclare une feuille de style css
//header('Cache-control: public'); // On decalre qu'elle peut être mise en cache

// On commence par déterminer le nom de la css

if($getSection == 'gallery') 
{
	// La css de la section gallery dépend de différents paramètres
	$galMinSize = (isset($_COOKIE['galMinSize']) AND is_numeric($_COOKIE['galMinSize']) AND $_COOKIE['galMinSize'] >= 100 AND $_COOKIE['galMinSize'] <= 200) ? $_COOKIE['galMinSize'] : GAL_MIN_SIZE;
	$galMinShadow = (isset($_COOKIE['galMinShadow'])) ? $_COOKIE['galMinShadow'] : GAL_MIN_SHADOW;
	$galMinShadowLitteral = $galMinShadow ? 'true' : 'false';
	$cacheCSS = DIR_CACHE_CSS.CSS_VERSION.'_'.$getSection.'_'.$galMinSize.'_'.$galMinShadowLitteral.'.css';
} 
else 
{
	$cacheCSS = DIR_CACHE_CSS.CSS_VERSION.'_'.$getSection.'.css';
}

// On effectue la gestion de cache et/ou génération de css

if(is_file($cacheCSS) && CACHE_ENABLED) // Si le fichier de cache existe
{	
	$cacheCSSsrc = file_get_contents($cacheCSS);
	echo $cacheCSSsrc; // On affiche le contenu du fichier
}
else // Sinon
{	
	// On met le contenu de la page dans un tampon
	
	ob_start();
	
	require DIR_STYLE.'script.style.css';
	
	if($getSection == 'gallery') 
	{
		require DIR_STYLE.'gallery.style.css';
		require DIR_STYLE.'gallery.dyn.style.php';
	} 
	elseif($getSection == 'admin') 
	{
		require DIR_STYLE.'admin.style.css';
	} 
	else 
	{
		require DIR_STYLE.'default.style.css';
	}
	
	$cacheCSSsrc = ob_get_flush(); // On récupère le contenu du tampon (et on vide le tampon)
	
	file_put_contents($cacheCSS, $cacheCSSsrc); // On crée le fichier de cache contenant la sortie du tampon
}