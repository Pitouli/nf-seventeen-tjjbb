<?php

///////////////////////////////////////////////////////////////////////////////
//   On sélectionne si demandé les photos qui seront listées sur la page    //
/////////////////////////////////////////////////////////////////////////////

if(isset($_POST['explore_by']))
{
	if($_POST['explore_by']=='album')
	{
		$select_photos = $bdd->prepare("SELECT id, id_album, title, id_price, status, webname, folder, extension FROM photos WHERE id_album=:id_album ORDER BY title");
		$select_photos->execute(array('id_album' => $_POST['id_album']));
		$listPhotos = $select_photos->fetchAll();
		
		if(empty($listPhotos)) { $infos[] = "L'album demandé ne contient pas de photos"; }	
	}
	elseif($_POST['explore_by']=='search')
	{
		if($_POST['search_type']=='and') {
			$search = "'%".preg_replace("/\s+/","%' AND title LIKE '%",trim($_POST['search']))."%'";
			$select_photos = $bdd->query("SELECT id, id_album, title, id_price, status, webname, folder, extension FROM photos WHERE title LIKE ".$search." ORDER BY title LIMIT 500");
			$listPhotos = $select_photos->fetchAll();
		}
		elseif($_POST['search_type']=='or') {
			$search = "'%".preg_replace("/\s+/","%' OR title LIKE '%",trim($_POST['search']))."%'";
			$select_photos = $bdd->prepare("SELECT id, id_album, title, id_price, status, webname, folder, extension FROM photos WHERE title LIKE ".$search." ORDER BY title LIMIT 500");
			$select_photos->execute(array('id_album' => $_POST['id_album']));
			$listPhotos = $select_photos->fetchAll();
		}
	}
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
                'rank' => $rank,
            ); // On remplit la liste organisée des albums

            unset($albums[$key]); // On supprime l'album de l'array pour accélerer la recherche

            $listAlbums = createTree($albums, $listAlbums, $alb['id'], $rank + 1); // Et on recherches ses propres fils
        }
    }

    return $listAlbums;
}

$sql = "SELECT id, id_parent, title FROM albums ORDER BY title ASC";
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

///////////////////////////////////////////////////////////////////////////////
//     					  On dresse la liste des prix				         //
/////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM prices";
$result = $bdd->query($sql);
$listPrices = $result->fetchAll();