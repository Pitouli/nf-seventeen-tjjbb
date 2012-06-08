$(document).ready(function () {

// SYSTEME DE MISE A JOUR INDIVIDUEL

function updateAjax(formId) {
	
	$('#'+formId+' .updateAjax').change(function(){
				
		updateValue = $(this).val(); // Valeur du champs (le titre de la pièce-jointe par exemple)
		updateType = $(this).attr('name'); // Le "name" du champs : attchmtTitle ; attchmtAlbum...
		infoId = $(this).parents('tr').find('.attchmtId').val(); // L'id de la pièce-jointe à modifier
		
		idAttchmt = infoId;
		
		inputId = '#'+updateType+'_'+infoId;
		
		$.post("/ajax/admin/updateAttchmt.html", { update_attchmt_type: updateType, update_attchmt_value: updateValue, update_attchmt_id: idAttchmt },
		
			function(success) {
				
				if(success) {
					$(inputId).animate({
						'backgroundColor':'#d7eed7', 
						'borderBottomColor':'#1c782b', 
						'borderTopColor':'#1c782b', 
						'borderLeftColor':'#1c782b', 
						'borderRightColor':'#1c782b', 
						'color':'#006600'}, 300, function(){
							$(inputId).animate({
								'backgroundColor':'white', 
								'color':'black'}, 1000
							);								
						}
					);
				}
				else {
					$(inputId).animate({
						'backgroundColor':'#f8c7c7', 
						'borderBottomColor':'#b31c1c', 
						'borderTopColor':'#b31c1c', 
						'borderLeftColor':'#b31c1c', 
						'borderRightColor':'#b31c1c', 
						'color':'#871616'}, 300, function(){
							$(inputId).animate({
								'backgroundColor':'white', 
								'color':'black'}, 1000
							);								
						}
					);	
				}
					
			}
			
		);
		
	});

}

// APPARITION DES FORMULAIRES LORS DU CLIC SUR LES LIENS

var treeAlbumLoaded = new Array();

$('.show_form_album_edit').click(function(){
	idAlbum = $(this).closest('.tree_album').children('.album_id:first').val();
	idParent = $(this).closest('.tree_album').children('.album_parent:first').val();
	
	$('.tree_album .form_album').slideUp();

	if(!treeAlbumLoaded['form_album_edit_'+idAlbum])
	{
		$.post("/ajax/admin/loadAlbTree.html", { album_id: idAlbum, part: 'form_album_edit' },
		
			function(html) {
				
				$('#form_album_edit_'+idAlbum).append(html);
				
				// On dresse la liste déroulante des albums
				htmlListAlbumsOptions = genOptionsAlbum(listAlbumsOptions, idParent, idAlbum);	
				if(idAlbum != 1) $('#form_album_edit_'+idAlbum+' select[name="album_parent"]').empty().append(htmlListAlbumsOptions);
				
				$('#form_album_edit_'+idAlbum).slideDown(); 
					
			}
			
		);	
		
		treeAlbumLoaded['form_album_edit_'+idAlbum] = true;
	}
	else 
	{
		$('#form_album_edit_'+idAlbum).slideDown(); 
	}



	return false;
});

$('.show_form_album_suppr').click(function(){
	idAlbum = $(this).closest('.tree_album').children('.album_id:first').val();
	
	$('.tree_album .form_album').slideUp();

	if(!treeAlbumLoaded['form_album_suppr_'+idAlbum])
	{
		$.post("/ajax/admin/loadAlbTree.html", { album_id: idAlbum, part: 'form_album_suppr' },
		
			function(html) {
				
				$('#form_album_suppr_'+idAlbum).append(html);
				
				// On dresse la liste déroulante des albums
				htmlListAlbumsOptions = genOptionsAlbum(listAlbumsOptions, idAlbum);	
				$('#form_album_suppr_'+idAlbum+' select[name="album_dest"]').empty().append(htmlListAlbumsOptions);
				
				$('#form_album_suppr_'+idAlbum).slideDown(); 
					
			}
			
		);
		
		treeAlbumLoaded['form_album_suppr_'+idAlbum] = true;
	}
	else 
	{
		$('#form_album_suppr_'+idAlbum).slideDown(); 
	}

	return false;	
});

$('.show_form_album_attchmt').click(function(){
	idAlbum = $(this).closest('.tree_album').children('.album_id:first').val();
	
	$('.tree_album .form_album').slideUp();
	
	if(!treeAlbumLoaded['form_album_attchmt_'+idAlbum])
	{
		$.post("/ajax/admin/loadAlbTree.html", { album_id: idAlbum, part: 'form_album_attchmt' },
		
			function(html) {
				
				$('#form_album_attchmt_'+idAlbum).append(html);
				
				// On dresse la liste déroulante des albums
				htmlListAlbumsOptions = genOptionsAlbum(listAlbumsOptions, idAlbum);	
				$('#form_album_attchmt_'+idAlbum+' select[name="attchmtAlbum"]').empty().append(htmlListAlbumsOptions);
				updateAjax('form_album_attchmt_'+idAlbum);
				
				$('#form_album_attchmt_'+idAlbum).slideDown(); 
					
			}
			
		);
		
		treeAlbumLoaded['form_album_attchmt_'+idAlbum] = true;
	}
	else 
	{
		$('#form_album_attchmt_'+idAlbum).slideDown(); 
	}
	
	return false;	
});

// GESTION DE L'AFFICHAGE EN HAUT DE FENËTRE DES ALBUMS

var $tree_album = $('.tree_album'); // La variable qui designe l'ensemble des tree_album
var $tree_album_fixed = $('#tree_album_fixed'); // La variable qui designe la div contenant les albums "fixent"
var $tree_alb; // Un variable qui designe chacun des tree_album
var tree_alb_ranks = new Array(); // une variable qui compte les occurences de chaque rank
var tree_alb_height = $('.tree_album:first').outerHeight() - 1; // La variable qui indique la hauteur d'un tree_album
var tree_alb_width = $('.tree_album:first').outerWidth(); // La variable qui indique la largeur d'un tree_album
var nb_tree_alb = $tree_album.length; // Nombre d'éléments "tree_album"

// On commence par déterminer quel est le rank de chaque album, et à compter le nombre d'albums ayant ce rank là
$tree_album.each(function(i){
	$tree_album[i] = $(this);
	$tree_album[i].initialPosTop = $(this).offset().top;
	$tree_album[i].id = $(this).children('.album_id:first').val();
	$tree_album[i].rank = $(this).children('.album_rank:first').val();		
	tree_alb_ranks[$tree_album[i].rank] = isNaN(tree_alb_ranks[$tree_album[i].rank]) ? 0 : tree_alb_ranks[$tree_album[i].rank];
	tree_alb_ranks[$tree_album[i].rank]++; // On incrémente le nombre d'occurences de ce rank
});

// On calcule les zindex
var tree_alb_ranks_zindex = new Array();
for(rank=0;rank<tree_alb_ranks.length;rank++) {
	tree_alb_ranks_zindex[rank] = nb_tree_alb;
	for(rk=0;rk<=rank;rk++) tree_alb_ranks_zindex[rank] -= tree_alb_ranks[rk];
}

// Et on met à jour
for(i=0;i<nb_tree_alb;i++){
	tree_alb_ranks_zindex[$tree_album[i].rank]++; 
	$tree_album[i].css({'color': 'inherit', 'z-index': tree_alb_ranks_zindex[$tree_album[i].rank], 'position': 'relative'});
}

$(window).bind("scroll", function() {
	var windowTop = $(window).scrollTop();

	// On cherche quel est le dernier album a être "masqué"
	
	var last_hidden_alb = new Array();
	var last_hidden_alb_rank;
	
	for(i=0;i<nb_tree_alb;i++){
		//alert($tree_album[i].rank);
		if($tree_album[i].initialPosTop - $tree_album[i].rank * tree_alb_height <= windowTop) {
			$tree_album[i].children('.form_album').slideUp();
			last_hidden_alb_rank = $tree_album[i].rank; // On ecrase la variable "last_hidden_alb_rank" jusqu'au dernier alb concerné pour connaître son rank
			last_hidden_alb[last_hidden_alb_rank] = i; // pour chaque rank, on sauvegarde le num du dernier album "masqué"
		}
		//$tree_album[i].css({'color': 'inherit', 'z-index': 20-2*$tree_album[i].rank, 'position': 'relative', 'top': 0});
	}	

	// Et on les réaffiche

	// On vide le conteneur des albums fixes
	$tree_album_fixed.empty(); 
	$tree_album_fixed.css('width', tree_alb_width);

	// on le remplit avec les quelques albums qui doivent être maintenus
	for(var rank=0;rank<=last_hidden_alb_rank;rank++) {
		i = last_hidden_alb[rank];
		title = $tree_album[i].find('.tree_album_title_text:first').text();
				
		$div = $(document.createElement("div")).addClass('tree_album').css({'marginLeft': rank*50, 'color': '#aaa', 'position': 'relative', 'z-index': $tree_album[i].css('z-index')});
		$div.appendTo($tree_album_fixed);
		$p = $(document.createElement("p")).addClass('tree_album_title').append(title);
		$p.appendTo($div);
		//$span = $(document.createElement("span")).addClass('tree_album_title_text');
		//$span.appendTo($p);
		//$a = $(document.createElement("a")).attr({'title': 'Remonter à l\'album', 'href': '#tree_album_'+$tree_album[i].id}).append(title);
		//$a.appendTo($p);

		//$tree_album[i].css({'color': '#aaa', 'z-index': 19-2*$tree_album[i].rank, 'position': 'relative', 'top': windowTop - $tree_album[i].initialPosTop + $tree_album[i].rank * tree_alb_height});
	}
});

});