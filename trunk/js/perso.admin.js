function genOptionsAlbum(albumTree, albumParent, albumID) {
	
	if(isNaN(albumParent)) albumParent = null;
	if(isNaN(albumID)) albumID = null;

	forbidAlbum = false;
	forbidAlbumRank = 0;
	
	optionsAlbum = '';
	
	for(alb in albumTree) {	
			
		if(albumTree[alb]['id']==albumID) { 
			forbidAlbum = true;
			forbidAlbumRank = albumTree[alb]['rank'];
		}
		else if(forbidAlbum && albumTree[alb]['rank']<=forbidAlbumRank) {
			forbidAlbum = false;
		}
		
		if(!forbidAlbum) {
			
			optionsAlbum = optionsAlbum+'<option value="'+albumTree[alb]['id']+'"';
			if(albumTree[alb]['id'] == albumParent) optionsAlbum = optionsAlbum+' selected="selected"';
			optionsAlbum = optionsAlbum+'>'+albumTree[alb]['title']+'</options>';
			
		}
			
	
	}
	
	return optionsAlbum;
	
}