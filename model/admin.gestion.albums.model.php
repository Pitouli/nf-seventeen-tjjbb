<?php

///////////////////////////////////////////////////////////////////////////////
//           On met à jour les données si on a modifié un album             //
/////////////////////////////////////////////////////////////////////////////

// SI LE FORMULAIRE D'EDITION D'UN ALBUM A ETE UTILISE

if(isset($_POST['album_form']) && $_POST['album_form'] == 'edit') 
{
	// On récupère les données
	
	$maj_albums_values['title'] = trim($_POST['album_title']);
	$maj_albums_values['description'] = trim($_POST['album_description']);
	$maj_albums_values['id'] = $_POST['album_id'];
	$maj_albums_values['id_parent'] = $_POST['album_parent'];
	$prix = trim($_POST['album_prix']);

	// On convertit le nom
	
	$str = new String();
	$str->setStr($maj_albums_values['title']);
	$maj_albums_values['web_title'] = $str->getWebify();
	$maj_albums_values['web_title'] = substr($maj_albums_values['web_title'], 0, 50);
	
	// On vérifie que l'album parent existe
	if($maj_albums_values['id'] == 1) // Si on modifie l'album ROOT (dont l'id est 1)
	{
		$id_parent_authorised = TRUE;
		$maj_albums_values['id_parent'] = 0;
	}
	elseif(is_numeric($maj_albums_values['id_parent']) && is_numeric($maj_albums_values['id'])) 
	{
		function listAlbumsId($albums, $forbidId, $id_parent=0, $rank=0, &$listAlbumsId = array())
		{
			foreach ($albums as $key => $alb)
			{ // Pour tous les albums
				if ($alb['id_parent'] == $id_parent)
				{ // Si l'album est un fils de l'album pour qui on les recherches
					if ($alb['id'] != $forbidId)
					{ // Si ce n'est pas l'album lui-même (et donc pas un de ses fils par arrêt de la réccurence)
						$listAlbumsId[] = $alb['id']; // On rajoute l'id à la liste des id possibles
			
						unset($albums[$key]); // On supprime l'album de l'array pour accélerer la recherche
			
						$listAlbumsId = listAlbumsId($albums, $forbidId, $alb['id'], $rank + 1, $listAlbumsId); // Et on recherches ses propres fils
					}
				}
			}
		
			return $listAlbumsId;
		}
		
		$sql = "SELECT id, id_parent FROM albums";
		$result = $bdd->query($sql);
		$albums = $result->fetchAll();
		
		$listAlbumsId = listAlbumsId($albums, $maj_albums_values['id']);
		
		if(in_array($maj_albums_values['id_parent'], $listAlbumsId)) { 
			$id_parent_authorised = TRUE; 
		}
		else {
			$errors[] = "Le déplacement de l'album n'a pas été possible. Ou l'album cible n'existe pas, ou c'est un <em>fils</em> de l'album à déplacer.";
		}
		
	}
	else {
		$errors[] = "Le déplacement de l'album n'a pas été possible. Nous n'avons pas reçu d'album cible.";
	}
	
	// Si les conditions sont respectées, on met à jour l'album
	
	if(!empty($maj_albums_values['title']) && $id_parent_authorised) {
		$maj_albums = $bdd->prepare("UPDATE albums SET title=:title, web_title=:web_title, id_parent=:id_parent, description=:description WHERE id=:id LIMIT 1");
		$maj_albums->execute($maj_albums_values);
		$success[] = "L'album <em>".$maj_albums_values['title']."</em> a bien été mis à jour.";
	}
	
	// On s'occupe de modifier le prix des photos si nécessaires
	
	if(is_numeric($prix) && $bdd->getNbRow('prices', 'id='.$prix) == 1) {
		$maj_photos = $bdd->prepare("UPDATE photos SET id_price=:prix WHERE id_album=:id");
		$maj_photos->execute(array('prix' => $prix, 'id' => $maj_albums_values['id']));
		$success[] = "Les photos de l'album <em>".$maj_albums_values['title']."</em> ont toutes eu leur prix mis-à-jour.";		
	}
	
	// On supprime le cache des albums de la galerie

	require DIR_MODEL.'admin.cleanCache.model.php';
}

// SI LE FORMULAIRE DE SUPPRESSION/MASQUAGE D'ALBUM A ETE UTILISE

elseif(isset($_POST['album_form']) && $_POST['album_form'] == 'suppr') 
{
	$id = $_POST['album_id'];
	
	if($_POST['album_suppraction'] == 'suppr' && is_numeric($id) && $id != 1)
	{
		if($_POST['album_suppr_confirm'])
		{
			$suppr_albums = $bdd->prepare("DELETE FROM albums WHERE id=:id LIMIT 1");
			$suppr_albums->execute(array('id' => $id));
			$success[] = "L'album a bien été supprimé.";
			
			$maj_photos = $bdd->prepare("UPDATE photos SET status='2suppr', id_album = :id_parent WHERE id_album=:id");
			$maj_photos->execute(array('id' => $id, 'id_parent' => $_POST['album_id_parent']));
			$success[] = "Les photos de l'album ont été signalées pour être supprimées automatiquement sous peu. Elles sont pour l'instant déplacées dans l'album parent.";
			
			$maj_attachments = $bdd->prepare("UPDATE attachments SET status='2suppr', id_album = :id_parent WHERE id_album=:id");
			$maj_attachments->execute(array('id' => $id, 'id_parent' => $_POST['album_id_parent']));
			$success[] = "Les fichiers attachés à l'album ont été signalées pour être supprimées automatiquement sous peu. Ils sont pour l'instant déplacés dans l'album parent.";
			
			$maj_albums = $bdd->prepare("UPDATE albums SET id_parent=:id_parent WHERE id_parent=:id");
			$maj_albums->execute(array('id_parent' => $_POST['album_id_parent'], 'id' => $id));
			$success[] = "Les sous-albums ont été \"remontés\" dans l'album parent.";		 			
		}
		else {
			$errors[] = "La suppression n'a pas eu lieu car vous ne l'avez pas confirmé en cochant la case en bout de ligne.";
		}
	}
	elseif($_POST['album_suppraction'] == 'move' && is_numeric($id) && $id != 1)
	{
		// NB SECURITE : on pourrait, comme c'est le cas lors du changement de dossier parent, vérifier que l'album cible existe bel et bien.. Mais bon, il est tard...
		
		if(is_numeric($_POST['album_dest']))
		{
			$suppr_albums = $bdd->prepare("DELETE FROM albums WHERE id=:id LIMIT 1");
			$suppr_albums->execute(array('id' => $id));
			$success[] = "L'album a bien été supprimé.";
			
			$maj_photos = $bdd->prepare("UPDATE photos SET id_album=:album_dest WHERE id_album=:id");
			$maj_photos->execute(array('album_dest' => $_POST['album_dest'], 'id' => $id));
			$success[] = "Les photos de l'album ont été déplacées vers l'album cible.";	
			
			$maj_attachments = $bdd->prepare("UPDATE attacments SET id_album=:album_dest WHERE id_album=:id");
			$maj_attachments->execute(array('album_dest' => $_POST['album_dest'], 'id' => $id));
			$success[] = "Les fichiers attachés à l'album ont été déplacées vers l'album cible.";	
			
			$maj_albums = $bdd->prepare("UPDATE albums SET id_parent=:album_dest WHERE id_parent=:id");
			$maj_albums->execute(array('album_dest' => $_POST['album_dest'], 'id' => $id));
			$success[] = "Les sous-albums ont été déplacés vers l'album cible.";				
		}
		else {
			$errors[] = "La suppression n'a pas eu lieu car nous n'avons pas reçu d'album cible valable.";
		}
	}
	elseif($_POST['album_suppraction'] == 'hide' && is_numeric($id) && $id != 1)
	{
		
		if($_POST['album_hide'])
		{
			$hide_albums = $bdd->prepare("UPDATE albums SET hide=1 WHERE id=:id LIMIT 1");
			$hide_albums->execute(array('id' => $id));
			$success[] = "L'album est maintenant masqué.";
		}
		elseif(!$_POST['album_hide'])
		{
			$show_albums = $bdd->prepare("UPDATE albums SET hide=0 WHERE id=:id LIMIT 1");
			$show_albums->execute(array('id' => $id));
			$success[] = "L'album est maintenant visible.";		
		}
		else {
			$errors[] = "Le système n'a pas compris le type de visibilité souhaité pour l'album.";
		}
	}
	else {
		$infos[] = "Aucune suppression/masquage n'a été effectuée. Nous rappelons que l'album <em>racine</em> ne peut faire l'objet de suppression/masquage.";
	}
	
	// On supprime le cache des albums de la galerie

	require DIR_MODEL.'admin.cleanCache.model.php';
}

// SI LE FORMULAIRE DE CREATION D'ALBUM A ETE UTILISE

elseif(isset($_POST['album_form']) && $_POST['album_form'] == 'add') 
{

	$add_albums_values['title'] = trim($_POST['album_title']);
	$add_albums_values['description'] = trim($_POST['album_description']);
	$add_albums_values['id_parent'] = $_POST['album_parent'];	
	$add_albums_values['date'] = date('Y-m-d');
	
	$str = new String;
	$str->setStr($add_albums_values['title']);
	$add_albums_values['web_title'] = $str->getWebify();
	$add_albums_values['web_title'] = substr($add_albums_values['web_title'], 0, 50);
	
	if(!empty($add_albums_values['web_title']) && is_numeric($add_albums_values['id_parent'])) // On fait quelques vérfications de base
	{
	
		// On compte le nombre d'album portant le même titre dans l'album parent
		$nb = $bdd->getNbRow('albums', 'id_parent="'.$add_albums_values['id_parent'].'" AND web_title="'.$add_albums_values['web_title'].'"');
		
		// Si l'album existe déja
		if($nb>=1) {
			// On met à jour
			$updateAlbum = $bdd->prepare("UPDATE albums SET updated = :date, description = :description WHERE id_parent= :id_parent AND web_title= :web_title");
			$updateAlbum->execute($add_albums_values);
			
			$success[] = "L'album a été mis à jour.";
		}
		// Si l'album n'existe pas
		else {
			// On le crée
			$insertAlbum = $bdd->prepare("INSERT INTO albums SET title = :title, web_title = :web_title, id_parent = :id_parent, created = :date, updated = :date, description = :description");
			$insertAlbum->execute($add_albums_values);
			
			$success[] = "Un nouvel album a été créé.";
		}
	
	}
	else {
		$errors[] = "Le titre de l'album est vide (ou composé uniquement de caractères spéciaux) ou l'album parent a mal été indiqué. Il n'a donc pu être créé.";
	}
	
	// On supprime le cache des albums de la galerie

	require DIR_MODEL.'admin.cleanCache.model.php';
}

///////////////////////////////////////////////////////////////////////////////
//       On organise dans un array tous les albums avec leurs infos         //
/////////////////////////////////////////////////////////////////////////////

function createTree($albums, &$listAlbums = array(), $id_parent=0, $rank=0)
{
    foreach ($albums as $key => $alb)
    { // Pour tous les albums
        if ($alb['id_parent'] == $id_parent)
        { // Si l'album est un fils de l'album pour qui on les recherches
            $listAlbums[] = array(
                'id' => $alb['id'],
                'id_parent' => $alb['id_parent'],
				'title' => $alb['title'],
				'description' => $alb['description'],
                'rank' => $rank,
				'hide' => $alb['hide']
            ); // On remplit la liste organisée des albums

            unset($albums[$key]); // On supprime l'album de l'array pour accélerer la recherche

            $listAlbums = createTree($albums, $listAlbums, $alb['id'], $rank + 1); // Et on recherches ses propres fils
        }
    }

    return $listAlbums;
}

$sql = "SELECT id, id_parent, title, description, hide FROM albums ORDER BY title ASC";
$result = $bdd->query($sql);
$albums = $result->fetchAll();

$listAlbums = createTree($albums);

$listAlbumsOptions = array();

foreach($listAlbums as $key => $alb)
{
	$title = '';
	
	for ($i = 1; $i <= $alb['rank']; $i++)
	{ 
		$title .= "&nbsp;-&nbsp;";
	}
	$title .= ' | '.$alb['title']; 
	
	$listAlbumsOptions[] = array('title' => $title, 'id' => $alb['id'], 'rank' => $alb['rank']);
}

$json_listAlbumsOptions = json_encode($listAlbumsOptions);

foreach($listAlbums as $key => $alb) {

	$listAlbums[$key]['nb_attachments'] = $bdd->getNbRow('attachments', 'id_album='.$listAlbums[$key]['id']);

}
