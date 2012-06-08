<?php  

//////////////////////////////////////////
//    STATISTIQUES GOOGLE ANALYTIC     //
////////////////////////////////////////

$ga = new Gapi(GA_EMAIL,GA_PASSWORD);
 
//on récupère les données du compte
$ga->requestAccountData();

// LES DONNEES PAR RAPPORT A AUJOURD'HUI
 
//la requête doit se faire sur une fourchette de dates au format yyyy-mm-dd
$today  = date('Y-m-d');
$prevDay = date('Y-m-d',time() - 86400); // 24 heures plus tôt
$prevMonth = date('Y-m-d',time() - 2635200); // 1 mois plus tôt
$prevYear = date('Y-m-d',time() - 31536000); // 1 an plus tôt

// on récupère les infos depuis 24 heures
$ga->requestReportData(GA_SITE, array('date'), array('pageviews','visits', 'visitors'), '-date', null, $prevDay,$today);
$stat['pageviews']['sinceDay'] = $ga->getPageviews();
$stat['visits']['sinceDay'] = $ga->getVisits();
$stat['visitors']['sinceDay'] = $ga->getVisitors();

// on récupère les infos depuis 1 mois
$ga->requestReportData(GA_SITE, array('date'), array('pageviews','visits', 'visitors'), '-date', null, $prevMonth,$today);
$stat['pageviews']['sinceMonth'] = $ga->getPageviews();
$stat['visits']['sinceMonth'] = $ga->getVisits();
$stat['visitors']['sinceMonth'] = $ga->getVisitors();

// on récupère les infos depuis 1 an
$ga->requestReportData(GA_SITE, array('date'), array('pageviews','visits', 'visitors'), '-date', null, $prevYear,$today);
$stat['pageviews']['sinceYear'] = $ga->getPageviews();
$stat['visits']['sinceYear'] = $ga->getVisits();
$stat['visitors']['sinceYear'] = $ga->getVisitors();

// LES DONNEES AVANT

//la requête doit se faire sur une fourchette de dates au format yyyy-mm-dd
$dayWeekAgo = date('Y-m-d', time() - 604800); // il y a une semaine
$prevDayWeekAgo = date('Y-m-d',time() - 691200); // 1 jour avant il y a une semaine
$prevMonthYearAgo = date('Y-m-d',time() - 34171200); // 1 mois avant il y a un an
$prevYearYearAgo = date('Y-m-d',time() - 63072000); // 1 an avant il y a un an
$prevYear = date('Y-m-d',time() - 31536000); // 1 an plus tôt

// on récupère les infos sur 1 jour de la semaine passée
$ga->requestReportData(GA_SITE, array('date'), array('pageviews','visits', 'visitors'), '-date', null, $prevDayWeekAgo,$dayWeekAgo);
$stat['pageviews']['dayWeekAgo'] = $ga->getPageviews();
$stat['visits']['dayWeekAgo'] = $ga->getVisits();
$stat['visitors']['dayWeekAgo'] = $ga->getVisitors();

// on récupère les infos sur 1 mois de l'année passée
$ga->requestReportData(GA_SITE, array('date'), array('pageviews','visits', 'visitors'), '-date', null, $prevMonthYearAgo,$prevYear);
$stat['pageviews']['monthYearAgo'] = $ga->getPageviews();
$stat['visits']['monthYearAgo'] = $ga->getVisits();
$stat['visitors']['monthYearAgo'] = $ga->getVisitors();

// on récupère les infos sur 1 an de l'année passée
$ga->requestReportData(GA_SITE, array('date'), array('pageviews','visits', 'visitors'), '-date', null, $prevYearYearAgo,$prevYear);
$stat['pageviews']['yearYearAgo'] = $ga->getPageviews();
$stat['visits']['yearYearAgo'] = $ga->getVisits();
$stat['visitors']['yearYearAgo'] = $ga->getVisitors(); 

// LES DONNEES DEPUIS LE DEBUT

// on récupère les infos depuis le début
$ga->requestReportData(GA_SITE, array('date'), array('visitors'), '-date', null, '2008-01-01',$today);
$stat['visitors']['sinceBeginning'] = $ga->getVisitors();

// on récupère les sources depuis 3 mois
$ga->requestReportData(GA_SITE, array('source'), array('visits'), '-visits', null, date('Y-m-d', time() - 7888320),$today);
$i = 0;
foreach($ga->getResults() as $result)
	{
		$stat['source'][$i]['url'] = $result->getSource();
		$stat['source'][$i]['occur'] = $result->getVisits();
		$i++;
	}
	
// on récupère les keyword depuis 3 mois
$ga->requestReportData(GA_SITE, array('keyword'), array('visits'), '-visits', null, date('Y-m-d', time() - 7888320),$today);
$i = 0;
foreach($ga->getResults() as $result)
	{
		$stat['keyword'][$i]['word'] = $result->getKeyword();
		$stat['keyword'][$i]['occur'] = $result->getVisits();
		$i++;
	}