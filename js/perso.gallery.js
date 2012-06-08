// On crée un cookie pour dire que javascript est activé
SetCookie("javascriptOn", 1, 60*60, '/');

ROOT = "/";
GAL_MIN_SHADOW = 1;
GAL_MIN_ROUNDED = 1;
SLIDESHOW_SPEED = 3000; // duree du slideshow, en millisecondes
SLIDESHOW_TRANSITION = "elastic"; // type de transition : elastic, fade ou aucune

/* ####################################################
#                  INFO BULLES TIPSY                  #
#################################################### */

$(document).ready(function(){
	
	// On nettoie les title normaux pour éviter des doubles affichages et on les stock dans des "tipsy"
	$('.galAlbDivImage').each(function() {
		$(this).attr('tipsy', "Ouvrir l'album<br>"+$(this).children('p').children('a').attr('title')); // On donne un attribut "tipsy" contenant le "title" du lien.
		$(this).children('p').children('a').removeAttr('title'); // On supprime le title du lien
	}); 
						   
	$('.galPictImage').tipsy({gravity: 's', fade: true, delayIn: 300, live: true, title: 'tipsy' });
	$('.galMinMenu a').tipsy({gravity: function() { return $(this).offset().left > ($(document).scrollLeft() + $(window).width() - 300) ? 'se' : 'sw'; }, fade: true, html: true, delayIn: 300});
	$('.galAlbDivImage').tipsy({gravity: 's', fade: true, html: true, live: true, title: 'tipsy'});
	$('#title a').tipsy({gravity: 'nw', fade: true, delayIn: 300, live: true});	
	$('#menu a').tipsy({gravity: 'nw', fade: true, delayIn: 300, live: true});
	$('#navParentLinkText').tipsy({gravity: 'sw', fade: true, live: true, title: function() { return 'Albums parents'; }});
	
}); // fin du "document ready"

/* ####################################################
#             	AFFICHAGE DES PANNEAUX                #
#################################################### */

$(document).ready(function(){
	
	// INFOBULLES
	
	$('#navButtonSlideshow img:first').tipsy({gravity: 'se', fade: true, live: true, title: function() { return 'Lancer le diaporama'; }});
	
	$('#navButtonDescription img:first').tipsy({gravity: 'se', fade: true, live: true, title: function() { 
		if($('#navPanelDescription').is(":visible"))
			return 'Masquer la description et les pièces jointes de l\'album';
		else
			return 'Montrer la description et les pièces jointes de l\'album';
	}});
	
	$('#navButtonParam img:first').tipsy({gravity: 'se', fade: true, live: true, title: function() { 
		if($('#navPanelParam').is(":visible"))
			return 'Masquer les paramètres de la galerie';
		else
			return 'Montrer les paramètres de la galerie';
	}});
	
	$('#navButtonCart img:first').tipsy({gravity: 'se', fade: true, live: true, title: function() { 
		if($('#navPanelCart').is(":visible"))
			return 'Masquer le caddie';
		else
			return 'Montrer le caddie';
	}});
	
	// GESTION DE L'AFFICHAGE DES PANNEAUX

	function showPanel(name) {
		if($('#navPanel'+name).is(":visible")) {
			$('#navButtons .navButtonBubble').slideUp();
			$('.navPanel').slideUp();
		}
		else {
			$('#navButtons .navButtonBubble').slideUp();
			$('.navPanel').slideUp();
			$('#navButton'+name+' .navButtonBubble').slideDown();
			$('#navPanel'+name).slideDown();
		}		
	}
	
	$('#navButtonDescription').click(function() { showPanel('Description') });
	$('#navButtonParam').click(function() { showPanel('Param') });
	$('#navButtonCart').click(function() { 
		updateNbItemInCart();
		showPanel('Cart');
	});
	
	// GESTION DE L'AFFICHAGE DES SECTIONS
	
	$('.navPanel .navPanelSection:not(:first-child) .navPanelSectionContent').slideUp(); // On masque au chargement toutes les sections sauf la première de chaque panneau
	
	$('.navPanelSectionTitle').click(function(){
		$navPanelSectionContent = $(this).parent('.navPanelSection:first').children('.navPanelSectionContent');
		if($navPanelSectionContent.is(':visible')) {
			$navPanelSectionContent.slideUp();
		}
		else {
			$('.navPanelSectionContent:visible').slideUp();
			$navPanelSectionContent.slideDown();
		}
	});
			
	
	// GESTION DU PARAM DE CHANGEMENT DE TAILLE
	
	var curPos;
	var clickPos;
	var clicking = false;
	var $testGalMinSize = $('#testGalMinSize');
	var testGalMinCurSize = $testGalMinSize.width();
	
	var fctParamMinSizeMouseup = function()
	{
		clicking=false;
		
		// On met à jour l'affichage général
		galMinSize = testGalMinNewSize;
		if(isNaN(galMinSize) || galMinSize < 100 || galMinSize > 200) galMinSize = 200; // Si la valeur n'est pas entre 100 et 200, on met 200
		SetCookie("galMinSize", galMinSize, 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
		$('.galMin').css('width',galMinSize+'px');
		$('.galMinPImage').css('width',galMinSize+'px');
		$('.galMinPImage').css('height',galMinSize+'px');
		dispositionModified();
		
		$(document).unbind('mousemove', fctParamMinSizeMousemove);
		$(document).unbind('mouseup', fctParamMinSizeMouseup);
		
		return false;
	};
	
	var fctParamMinSizeMousemove = function(e)
	{
		if(clicking)
		{
			curPos = e.pageX; // Actual X position of the cursor
			
			// On calcule la taille que devrait avoir le carré d'après le mouvement de l'utilisateur
			testGalMinNewSize = testGalMinCurSize + (curPos-clickPos);
			
			// Si cette taille dépasse les extrêmes autorisés, on recadre
			if(testGalMinNewSize>200) testGalMinNewSize = 200;
			else if(testGalMinNewSize<100) testGalMinNewSize = 100;
			
			// On met à jour la taille de l'exemple
			$testGalMinSize.width(testGalMinNewSize);
			$testGalMinSize.height(testGalMinNewSize);
		}
		
		return false;
	};
	
	$testGalMinSize.mousedown(function(e)
	{
		clicking=true;
		clickPos = e.pageX; // X position of the cursor at the click
		testGalMinCurSize = $testGalMinSize.width(); // On met à jour la taille du carré au moment du clic
		
		$(document).bind('mousemove', fctParamMinSizeMousemove);
		$(document).bind('mouseup', fctParamMinSizeMouseup);
		
		return false;
	});
	
	// GESTION DU PARAM D'OMBRAGE DES MINIATURES
	
	var $checkboxGalMinShadow = $("#checkboxGalMinShadow");
	
	var galMinShadow = parseInt((GetCookie("galMinShadow") !== null) ? GetCookie("galMinShadow") : GAL_MIN_SHADOW);
	
	if(galMinShadow) $checkboxGalMinShadow.attr('checked','checked');
	else $checkboxGalMinShadow.removeAttr('checked');
	
	$checkboxGalMinShadow.change(function(){ 
		if($(this).attr('checked')) 
		{
			SetCookie("galMinShadow", 1, 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
			$('.galMinImage').css('box-shadow','5px 5px 5px #050505');
			$('.galMinImage').css('-moz-box-shadow','5px 5px 5px #050505');
			$('.galMinImage').css('-webkit-box-shadow','5px 5px 5px #050505');
		}
		else
		{
			SetCookie("galMinShadow", 0, 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
			$('.galMinImage').css('box-shadow','none');
			$('.galMinImage').css('-moz-box-shadow','none');
			$('.galMinImage').css('-webkit-box-shadow','none');
		}
	});

	// GESTION DU PARAM D'ARRONDI DES MINIATURES
	
	var $checkboxGalMinRounded = $("#checkboxGalMinRounded");
	
	var galMinRounded = parseInt((GetCookie("galMinRounded") !== null) ? GetCookie("galMinRounded") : GAL_MIN_ROUNDED);
	
	if(galMinRounded) $checkboxGalMinRounded.attr('checked','checked');
	else $checkboxGalMinRounded.removeAttr('checked');
	
	$checkboxGalMinRounded.change(function(){ 
		if($(this).attr('checked')) 
		{
			SetCookie("galMinRounded", 1, 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
			$('.galPictImage').css('border-radius','10px');
			$('.galPictImage').css('-moz-border-radius','10px');
			$('.galPictImage').css('-webkit-border-radius','10px');
		}
		else
		{
			SetCookie("galMinRounded", 0, 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
			$('.galPictImage').css('border-radius','0px');
			$('.galPictImage').css('-moz-border-radius','0px');
			$('.galPictImage').css('-webkit-border-radius','0px');
		}
	});

	// GESTION DU PARAM DE VITESSE DU DIAPORAMA
	
	var $selectSlideshowSpeed = $("#selectSlideshowSpeed");
	
	$selectSlideshowSpeed.change(function(){ 
		if($(this).val() >= 500 && $(this).val() <= 60000) 
		{
			SetCookie("slideshowSpeed", $(this).val(), 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
		}
		else
		{
			SetCookie("slideshowSpeed", SLIDESHOW_SPEED, 60*60*24*30*6, '/'); // On s'en souvient pendant 6 mois
		}
	});

	// GESTION DU PARAM DE TRANSITION DU DIAPORAMA
	
	var $selectSlideshowTransition = $("#selectSlideshowTransition");
	
	$selectSlideshowTransition.change(function(){ 
		if($(this).val() == "elastic") SetCookie("slideshowTransition", "elastic", 60*60*24*30*6, '/'); 
		else if($(this).val() == "fade") SetCookie("slideshowTransition", "fade", 60*60*24*30*6, '/');
		else if($(this).val() == "none") SetCookie("slideshowTransition", "none", 60*60*24*30*6, '/');
		else SetCookie("slideshowTransition", SLIDESHOW_TRANSITION, 60*60*24*30*6, '/');  
	});
		
}); // fin du "document ready"

/* ####################################################
#              GESTION DU PANIER                      #
#################################################### */

function updateNbItemInCart() {
	nbItemInCart = countSel('alb','galCart')+countSel('HD','galCart')+countSel('FD','galCart');
	$(".nbItemInCart").text(nbItemInCart);
}

function switchInCart(id,name) {
	add2sel(id,name,'A','galCart'); 
	updateNbItemInCart();
	reloadCartContent();
	return false;
}

function emptyCartContent() {
	$("#cartContentSectionContent").empty().append($(document.createElement("p")).text("Caddie en cours de chargement...")); // On vide l'affichage du contenu
	$("#cartContentSectionRefresh").hide();
}

function loadCartContent() {
	$.ajax({
		url: ROOT+'ajax/gallery/cartContent.html',
		success: function(html) {
			$("#cartContentSectionContent").empty().html(html);
		}
	});		
}

function reloadCartContent() {
	$("#cartContentSectionRefresh").show();	
}

$(document).ready(function(){
	updateNbItemInCart();
	
	var lastCart;
	var cartContentSectionContentVisible = 0;
	
	$("#cartContentSectionTitle").click(function() {
		if(!cartContentSectionContentVisible) // Si la section était masquée et que le clic la fait apparaître
		{		
			cartContentSectionContentVisible = 1; // Alors on la définit visible
			if(GetCookie('galCart') != lastCart) // Si le panier a changé
			{
				emptyCartContent();
				loadCartContent();
				lastCart = GetCookie('galCart');					
			}
		}
		else cartContentSectionContentVisible = 0; // Sinon, c'est qu'on la masque
	});
	
	$("#cartContentSectionRefreshButton").click(function() {
		emptyCartContent();
		loadCartContent();
		lastCart = GetCookie('galCart');		
	});
});

/* ####################################################
#              GESTION DES FAVORIS                    #
#################################################### */

function updateNbItemInFav() {
	nbItemInFav = countSel('alb','galSel')+countSel('pict','galSel');
	$(".nbItemInFav").text(nbItemInFav);
}

function switchInFav(id,name) {
	add2sel(id,name,'A','galSel'); 
	updateNbItemInFav();
	return false;
}

$(document).ready(function(){
	updateNbItemInFav();
});

/* ####################################################
#     				   ADD2SELECT				      #
#################################################### */

function inArray(array, p_val) {
    var l = array.length;
    for(var i = 0; i < l; i++) {
        if(array[i] == p_val) {
            return i;
        }
    }
    return -1;
}

// Paramètres : ID à ajouter ; name de l'élément : pict ou alb... ; type de l'élément : A pour "array", V pour "value" ; cookie dans lequel stocker
// Return : Si on a ajouté l'id, on renvoie 1. Si on l'a enlevé, on renvoie 0.
function add2sel(id,name,type,cookie) { 
	var galSel = GetCookie(cookie);
	var add = 1; // Par défaut, on ajoute l'id
	var regGlobal = new RegExp("^(<[a-zA-Z0-9]+:[A|V]:([-0-9]*)>)+$","g");
	if(galSel && galSel.match(regGlobal)) {
		var reg=new RegExp("<"+name+":"+type+":([-0-9]+)?>","g");
		if(galSel.match(reg)) { // Si le cookie existait déjà et correspond à la structure recherchée
			selID = reg.exec(galSel);
			var selID = selID[1] ? selID[1] : '';
			
			if(selID=='') selID = id;		
			else {
				var arraySel = selID.split('-');
			
				var i = inArray(arraySel,id); // index de l'id dans le tableau ; -1 s'il n'y est pas
				if(i >= 0) { // si l'élément est déjà dans le tableau, on le supprime
					arraySel.splice(i,1);
					add = 0; // On indique qu'on a fait une suppression
				}
				else arraySel.push(id); // sinon on l'y ajoute	
				
				selID = arraySel.join('-');	
			}
			galSel = galSel.replace(reg,"<"+name+":"+type+":"+selID+">");
		}
		else {
			galSel = galSel+"<"+name+":"+type+":"+id+">";
		}
	}
	else {
		galSel = "<"+name+":"+type+":"+id+">";
	}
	SetCookie(cookie, galSel, 60*60*24*30*6, '/');	
	//alert(galSel);
	return add;
};

function countSel(name,cookie) {
	var galSel = GetCookie(cookie); // On récupère le cookie
	var reg=new RegExp("<"+name+":A:([-0-9]+)?>","g");
	
	if(galSel && galSel.match(reg)) { // Si le cookie existe, on y cherche la sélection demandée
		selID = reg.exec(galSel);
		var selID = selID[1] ? selID[1] : '';
		if(selID!=''){
			var arraySel = selID.split('-');
			return arraySel.length; // Si il y a une sélection, on retourne le nb d'éléments
		} 
		else return 0;	
	}
	else return 0;
	
	return 0;
};

/*function add2fav(id,type) { // ID à ajouter ; type de l'élément : pict ou alb...
	var fav = GetCookie("galFav");
	var reg=new RegExp("^#pict:([-0-9]+)?#alb:([-0-9]+)?$","g");
	if(fav && fav.match(reg)) { // Si le cookie existait déjà et correspond à la structure recherchée
		favID = reg.exec(fav);
		var favPict = favID[1] ? favID[1] : '';
		var favAlb = favID[2] ? favID[2] : '';
		//alert('favPict : '+favPict);
		//alert('favAlb : '+favAlb);
		
		if(type=='pict' && favPict=='') favPict = id;
		else if(type=='alb' && favAlb=='') favAlb = id; 		
		else {
			if(type=='pict') var arrayFav = favPict.split('-');
			else if(type=='alb') var arrayFav = favAlb.split('-');
		
			var i = inArray(arrayFav,id); // index de l'id dans le tableau ; -1 s'il n'y est pas
			if(i >= 0) arrayFav.splice(i,1); // si l'élément est déjà dans le tableau, on le supprime
			else arrayFav.push(id); // sinon on l'y ajoute	
			
			if(type=='pict') favPict = arrayFav.join('-');
			else if(type=='alb') favAlb = arrayFav.join('-');		
		}
		//alert('favPict2 : '+favPict);
		//alert('favAlb2 : '+favAlb);
		fav = '#pict:'+favPict+'#alb:'+favAlb;
	}
	else {
		if(type=='pict') fav = '#pict:'+id+'#alb:';
		else if(type=='alb') fav = '#pict:#alb:'+id;
	}
	SetCookie("galFav", fav, 60*60*24*30*6, '/');	
	alert(fav);
};*/

/* ####################################################
#        COINS ARRONDIES POUR INTERNET EXPLORER       #
#################################################### */

// $("#menu").corner("8px");
	
/* ####################################################
#               NAVIGATION  AU CLAVIER                #
#################################################### */

$(document).ready(function(){

	// REDIRECTION SUR L'INTERFACE D'ADMINISTRATION QUAND LE MOT ADMIN EST ECRIT

/*	var word;
	
	$(this).bind("keydown", function(event) {
		
		if (event.keyCode == 65) {
			word = "a";
		}
		else if (word == "a" && event.keyCode == 68) {
			word = "ad";
		}
		else if (word == "ad" && event.keyCode == 77) {
			word = "adm";
		}
		else if (word == "adm" && event.keyCode == 73) {
			word = "admi";
		}
		else if (word == "admi" && event.keyCode == 78) {
			window.location = ROOT+"admin.html";
			word = false;
		}
		else {
			word = false;
		}
		
		return true;
	});*/
	
	
	var word_K = [];
	var word_admin = [];
	
    function word_K_capture(e){
        word_K.push(e.keyCode);
        if (word_K.toString().indexOf("38,38,40,40,37,39,37,39,66,65") >= 0) {
            $(this).unbind('keydown', word_K_capture);
            alert('KONAMI !!!!');
			alert('Bravo, tu as découvert le grand secret');
			alert('Toutes mes félicitations !');
			alert('Tu mérites une GRANDE récompense !');
			alert('Géante même !');
			alert('Par contre je dois avouer que...');
			alert('tous les épileptiques auraient intérêt à partir très loin avant de cliquer sur OK !!');
			alert('J\'aurais prévenu...');
			alert('Tadaaaa !');
			$('html').css('backgroundImage','url(/style/images/design/bgK.gif)');
        }
    }
	
    function word_admin_capture(e){
        word_admin.push(e.keyCode);
        if (word_admin.toString().indexOf("65,68,77,73,78") >= 0) {
            $(this).unbind('keydown', word_admin_capture);
            window.location = ROOT+"admin.html";
        }
    }
	
    $(document).keydown(word_K_capture);
	$(document).keydown(word_admin_capture);
	
}); // fin du "document ready"

/* ####################################################
#        CHARGEMENT DIFFERE DES PHOTOS GALERIE        #
#################################################### */

var $elements = null;
var threshold = 200;
var placeholder = ROOT+"style/images/trans.gif";
var positions = {};
var allpositions = null;

// FONCTION DE CALCUL DES POSITIONS DES IMAGES

function lookupTable(param) {
	
	if(!param) { param = 'install'; }
	
	if(param == 'install' || param == 'update') {
		
		positions = {};
	
		$elements.each(function() {			   
			_p = $(this).offset().top;
			if(positions[_p]===undefined) {
				positions[_p] = [];
			}
			positions[_p].push(this);
		});
		
		if (param == 'update') { $(window).trigger("scroll"); }
		
	}
	else if (param == 'destroy') {
		
		$elements.each(function() {
			$(this).attr("src", placeholder);
			$(this).loaded = true;
			$(this).unbind();
		});
		positions = {};
		$elements = null;
	
	}
	
};

// PRISE EN COMPTE DES CHANGEMENTS DE MISE EN PAGE 

function dispositionModified() {

	lookupTable('update');
	
}
	
$(document).ready(function(){
						   
	$(window).resize(function() {
		dispositionModified();
	});
	
}); // fin du "document ready"


$(document).ready(function(){

	// CREATION DES MINIATURES

	// On récupère la largeur de la div principale, qui sera donc la hauteur des miniatures.
	//minHeight = $(".galMin:first").width();
	
	//$("#gallery .galPictDivImage").each(function(i){
	$("#gallery .galPictPImage").each(function(i){
		
		//$(this).attr('tipsy', 'Voir l\'image en grand'); // On donne un attribut "tipsy" à la div
		$(this).empty(); // on vide la div du noscript
		
		// On insère dans la div la miniature transparente et son lien
		//$pictP = $(document.createElement("p")).addClass('galMinPImage galPictPImage');
		//$pictP.appendTo(this);
		$pictLink = $(document.createElement("a")).attr({'href': galPictFolderSD+galPictImage[i]['photo'], 'rel': "gallery", 'colorbox': galPictImage[i]['title']});
		$pictLink.appendTo(this);
		//$pict = $(document.createElement("img")).attr({'src': placeholder, 'original': galPictFolderMIN+galPictImage[i]['photo'], 'alt': galPictImage[i]['title'], 'class': 'galMinImage galPictImage', 'height': minHeight, 'width': minHeight});
		$pict = $(document.createElement("img")).attr({'src': placeholder, 'original': galPictFolderMIN+galPictImage[i]['photo'], 'alt': galPictImage[i]['title'], 'class': 'galMinImage galPictImage', 'tipsy': 'Voir l\'image en grand'});
		$pict.appendTo($pictLink);
		
		$pict.width(galPictImage[i]['w']+'%');
		$pict.height(galPictImage[i]['h']+'%');
		
		// On indique que la miniature "réelle" n'est toujours pas chargée
		$pict.loaded = false; 

		// On rattache un événement de chargement à la miniature
		$pict.one("appear", function() {
			if (!this.loaded) {
				$(this).attr("src", $(this).attr("original"));
				this.loaded = true;
			}
		});	

	});

	$elements = $("#gallery .galPictImage");

	// GESTION DE L'AFFICHAGE AU SCROLL
	
	$(window).bind("scroll", function(event) {
		var _top = $(window).scrollTop();
		var _bottom = _top + $(window).height();
		_top = _top - threshold;
		_bottom = _bottom + threshold;
		for (var pos in positions) {
			if (pos >= _top && pos <= _bottom) {
				for (var ele in positions[pos]) {
					ele = positions[pos][ele];
					$(ele).trigger("appear");
				}
			}
		}
		// Remove image from array so it is not looped next time. 
		var temp = $.grep($elements, function($element) {
			return !$element.loaded;
		});
		$elements = $(temp);
		// When all images have been loaded
		if($elements.length < 1) {
			$(window).unbind('scroll'); // Stop to listen to scroll
		}
	});	

	// ON INITIALISE ET LANCE L'AFFICHAGE SCROLL

	/* Force initial check if images should appear. */
	lookupTable('install');
	$(window).trigger("scroll");
	/* Force to recheck 1,5 second after first check (in case first check was done with with image not at full size) */
	//window.setTimeout("lookupTable('update')", 1500)

}); // fin du "document ready"

/* ####################################################
#      GESTION DE L'AFFICHAGE DES PHOTOS GALERIE      #
#################################################### */

$(document).ready(function(){
	
	slideshowAuto = 0;
	pageNavArrowKeyDisabled = 0;
	
	slideshowSpeedParam = parseInt((GetCookie("slideshowSpeed") !== null) ? GetCookie("slideshowSpeed") : SLIDESHOW_SPEED);
	slideshowTransitionParam = (GetCookie("slideshowTransition") !== null) ? GetCookie("slideshowTransition") : SLIDESHOW_TRANSITION;

	
	// On gère l'affichage des photos par les miniatures (sans diaporama auto)
	$("#gallery a[rel='gallery']").colorbox({
		slideshow:true,
		slideshowAuto:false,
		transition: slideshowTransitionParam,
		slideshowStart:"Démarrer le diaporama",
		slideshowStop:"Arrêter le diaporama",
		previous:"précédent",
		next:"suivant",
		close:"fermer",
		slideshowSpeed: slideshowSpeedParam,
		preloading:true,
		current:"{current}/{total}",
		maxHeight:"100%",
		maxWidth:"100%",
		title: function(){ return $(this).attr('colorbox'); },
		onOpen:function(){ pageNavArrowKeyDisabled = 1; },
		onClosed:function(){ pageNavArrowKeyDisabled = 0; }
	});	
	
	// On simule lors du clic sur le bouton diaporama un clic sur la première vignette et on déclare un diapo auto
	$("#navButtonSlideshow").click(function() {
		slideshowAuto = 1;
		$("a[rel='gallery']:first").click();
	});
	
	// en cas de diapo auto, on simule un clic sur le bouton "démarrer diapo"
	$(document).bind('cbox_load', function(){
		if(slideshowAuto) { $('.cboxSlideshow_off').find('#cboxSlideshow').click(); slideshowAuto = 0; }
	});

}); // fin du "document ready"

/* ####################################################
#                 GESTION DES COOKIES                 #
#################################################### */

//  Cookie Functions -- "Night of the Living Cookie" Version (25-Jul-96)
//  Written by:  Bill Dortch, hIdaho Design <bdortch@hidaho.com>


//  "Internal" function to return the decoded value of a cookie
function getCookieVal (offset) {
  var endstr = document.cookie.indexOf(";", offset);
  if (endstr == -1)
	{ endstr = document.cookie.length; }
  return unescape(document.cookie.substring(offset, endstr));
}


//  Function to return the value of the cookie specified by "name".
//    name -    String object containing the cookie name.
//    returns - String object containing the cookie value,
//              or null if the cookie does not exist.
//
function GetCookie (name) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen) {
	var j = i + alen;
	if (document.cookie.substring(i, j) == arg)
	  { return getCookieVal(j); }
	i = document.cookie.indexOf(" ", i) + 1;
	if (i == 0) { break; } 
  }
  return null;
}


//  Function to create or update a cookie.
//    name - String object containing the cookie name.
//    value - String object containing the cookie value.  May contain
//         any valid string characters.
//    [expires] - Durée de vie en secondes.  If
//         omitted or null, expires the cookie at the end of the current session.
//    [path] - String object indicating the path for which the cookie is valid.
//         If omitted or null, uses the path of the calling document.
//    [domain] - String object indicating the domain for which the cookie is
//         valid. If omitted or null, uses the domain of the calling document.
//    [secure] - Boolean (true/false) value indicating whether cookie
//         transmission requires a secure channel (HTTPS).  
//
//  The first two parameters are required.  The others, if supplied, must
//  be passed in the order listed above.  To omit an unused optional field,
//  use null as a place holder.  For example, to call SetCookie using name,
//  value and path, you would code:
//
//      SetCookie ("myCookieName", "myCookieValue", null, "/");
//
//  Note that trailing omitted parameters do not require a placeholder.
//
//  To set a secure cookie for path "/myPath", that expires after the
//  current session, you might code:
//
//      SetCookie (myCookieVar, cookieValueVar, null, "/myPath", null, true);
//
function SetCookie (name,value,expiration,path,domain,secure) {
	expires = new Date();  
	expires.setTime(expires.getTime() + (expiration*1000));	
  document.cookie = name + "=" + escape(value) +
	((expires) ? "; expires=" + expires.toGMTString() : "") +
	((path) ? "; path=" + path : "") +
	((domain) ? "; domain=" + domain : "") +
	((secure) ? "; secure" : "");
}


//  Function to delete a cookie. (Sets expiration date to start of epoch)
//    name -   String object containing the cookie name
//    path -   String object containing the path of the cookie to delete.
//             This MUST be the same as the path used to create the cookie, or
//             null/omitted if no path was specified when creating the cookie.
//    domain - String object containing the domain of the cookie to delete.
//             This MUST be the same as the domain used to create the cookie, or
//             null/omitted if no domain was specified when creating the cookie.
//
function DeleteCookie (name,path,domain) {
  if (GetCookie(name)) {
	document.cookie = name + "=" +
	  ((path) ? "; path=" + path : "") +
	  ((domain) ? "; domain=" + domain : "") +
	  "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  }
}
