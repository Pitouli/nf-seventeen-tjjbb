<?php

function createTree($albums, $listSelectOptionAlbum = NULL, $indent_pattern = '&nbsp;-&nbsp;', $id_parent=0, $rank=0, $indent = NULL, $forbid_id = NULL) {
	foreach ($albums as $key => $alb) { // Pour tous les albums
		if($alb['id_parent'] == $id_parent AND $alb['id'] != $forbid_id) { // Si l'album est un fils de l'album pour qui on les recherches	
			$listSelectOptionAlbum .= '<option value="'.$alb['id'].'">'.$indent.'|&nbsp;'.utf8_encode($alb['title']).'</option>'; // On affiche le fils
			unset($albums[$key]); // On supprime l'album de l'array pour accélerer la recherche
			createTree($albums, $listSelectOptionAlbum, $indent_pattern, $alb['id'], $rank+1, $indent.$indent_pattern, $forbid_id); // Et on recherches ses propres fils
		}
	}
	return $listSelectOptionAlbum;
}