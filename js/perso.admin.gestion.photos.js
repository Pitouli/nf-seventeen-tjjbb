$(document).ready(function () {

// Système de sélection

$('#checkPhotoAll').click(function(){
	$('.photoChecked').attr('checked', true);
	return false;
});
$('#checkPhotoNone').click(function(){
	$('.photoChecked').attr('checked', false);
	return false;
});
$('#checkPhotoInv').click(function(){
	$('.photoChecked').each(function(){
		if($(this).attr('checked')) {
			$(this).attr('checked', false);
		} 
		else {
			$(this).attr('checked', true);
		}
	});
	return false;
});
$('#checkPhoto2suppr').click(function(){
	$('.photoChecked').each(function(){
		status = $(this).parents('tr').find('.photoStatus').val();
		if(status=='2suppr') {
			$(this).attr('checked', true);
		} 
		else {
			$(this).attr('checked', false);
		}
	});
	return false;
});
$('#checkPhotoHide').click(function(){
	$('.photoChecked').each(function(){
		status = $(this).parents('tr').find('.photoStatus').val();
		if(status=='hide') {
			$(this).attr('checked', true);
		} 
		else {
			$(this).attr('checked', false);
		}
	});
	return false;
});
$('#checkPhotoVisible').click(function(){
	$('.photoChecked').each(function(){
		status = $(this).parents('tr').find('.photoStatus').val();
		if(status=='visible') {
			$(this).attr('checked', true);
		} 
		else {
			$(this).attr('checked', false);
		}
	});
	return false;
});
$('#checkPhotoPrice').change(function(){
	price2check = $(this).val();
	$('.photoChecked').each(function(){
		price = $(this).parents('tr').find('.photoPrice').val();
		if(price==price2check) {
			$(this).attr('checked', true);
		} 
		else {
			$(this).attr('checked', false);
		}
	});
	$(this).val('titleOfTheSelect')
	return false;
});

// Gestion du checkage avec la touche majuscule

$('.photoChecked').click(function(evt) {
	if(evt.shiftKey) { // Si la touche MAJ est enfoncée
		lastPhotoCheckedIndex = $('.photoChecked').index(this);
		if(prevPhotoCheckedIndex<=lastPhotoCheckedIndex) {
			for(var i = prevPhotoCheckedIndex; i <= lastPhotoCheckedIndex; i++)
				{
					 $('.photoChecked').eq(i).attr('checked', prevPhotoCheckedValue);
				}			
		}
		else {
			for(var i = lastPhotoCheckedIndex; i <= prevPhotoCheckedIndex; i++)
				{
					 $('.photoChecked').eq(i).attr('checked', prevPhotoCheckedValue);
				}			
		}
	}
	else { // Si la touche MAJ n'est pas enfoncée
		prevPhotoCheckedIndex = $('.photoChecked').index(this);
		prevPhotoCheckedValue = $(this).attr('checked');
	}

});

// Système de mise à jour individuel
	
$('.updateAjax').change(function(){
			
	updateValue = $(this).val(); // Valeur du champs (le titre de la photo par exemple)
	updateType = $(this).attr('name'); // Le "name" du champs : photoTitle ; photoAlbum...
	infoId = $(this).parents('tr').find('.photoId').val(); // L'id de la photo à modifier, ou "check" si c'est une modification globale
	
	if(infoId == 'check') { // Si on a utilisé le champs de modification "global"
		idPhoto = new Array();
		$('.photoChecked:checked').each(function(){
			idPhoto.push($(this).parents('tr').find('.photoId').val());
		});		
	}
	else {
		idPhoto = infoId;		
	}
	
	inputId = '#'+updateType+'_'+infoId;
	
	$.post("/ajax/admin/updatePhoto.html", { update_photo_type: updateType, update_photo_value: updateValue, update_photo_id: idPhoto },
	
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
				// Si on a fait une modif globale et qu'elle a réussie
				if(infoId=='check') {
					for(var i = 0; i < idPhoto.length; i++)
						{
							 $('#'+updateType+'_'+idPhoto[i]).val(updateValue); // On met à jour le choix chez les photos concernées
						}
				}
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
			
			// Si on a fait une modif globale
			if(infoId=='check') {
				$(inputId).val('titleOfTheSelect'); // On "remet à zéro" la liste de choix utilisée
			}
				
		}
		
	);
	
});

// Système d'aperçu des photos

$('.tdPreview').mouseover(function() { // Lors du survol

	$imgMin = $(this).find('img'); // On crée un objet jquery désignant la miniature
	if($imgMin.attr('src')!=$imgMin.attr('rel')) { $imgMin.attr('src',$imgMin.attr('rel')); } // Si la miniature n'a jamais été survolé (et que la src n'a jamais été mise en place) on l'indique
	$imgMin.show(); // On fait apparaître la miniature
	
	$(this).mouseout(function() { // Lorsqu'on quitte l'élément
		$imgMin.hide(); // On fait disparaître la miniature
	});
	
});

$('.photoAlbum').each(function(){
	idAlbum = $(this).parents('.trListPhotos:first').find('.albumId:first').val();
	$(this).empty().append(genOptionsAlbum(listAlbumsOptions, idAlbum));
});

$('.photoAlbum:last').prepend('<option value="titleOfTheSelect" selected="selected">Album</option>');

});