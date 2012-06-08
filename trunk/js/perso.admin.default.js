$(document).ready(function () {
	
	// Chargement initial du logbook
	$.post("/ajax/admin/logbook.html", {}, function(html) {
			$("#logbookDiv").html(html);
			activeReloadLogbook();
		}	
	);
	
	// Rechargement du logbook
	function activeReloadLogbook() {
		$('#logbookReboot').click(function(){
			$.post("/ajax/admin/logbook.html", {
					logbookLimit : $('#logbookLimit').val(), 
					logbookType : $('#logbookType').val(), 
					logbookSuccess : $('#logbookSuccess').val()
				}, function(html) {
					$("#logbookDiv").html(html);
					activeReloadLogbook();
				}	
			);		
		});
	}
	
	// Chargement des statistiques de fréquentation
	$.post("/ajax/admin/stats.html", {}, function(html) {
			$("#statsFreqDiv").html(html);
		}	
	);
	
});