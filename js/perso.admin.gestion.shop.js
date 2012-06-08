$(document).ready(function () {

// Système de mise à jour individuel
	
$('.updateAjax').change(function(){
	
	updateValue = $(this).val(); // Valeur du champs (le titre de la catégorie de prix par exemple)
	updateType = $(this).attr('name'); // Le "name" du champs : title ; HD...
	idPrice = $(this).parents('tr').find('.priceId').val(); // L'id de la catégorie de prix à modifier
	
	inputId = '#price_'+updateType+'_'+idPrice;
	
	$.post("/ajax/admin/updateShop.html", { update_price_type: updateType, update_price_value: updateValue, update_price_id: idPrice },
	
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

});