<?php 
if(isset($errors)) {
	echo '<div class="report errors"><p>Rapport d\'erreur&nbsp;:</p><ul>';
	foreach($errors as $err) { echo '<li>'.$err.'</li>'; };
	echo '</ul></div>';
}
if(isset($success)) {
	echo '<div class="report success"><p>Rapport des succès&nbsp;:</p><ul>';
	foreach($success as $suc) { echo '<li>'.$suc.'</li>'; };
	echo '</ul></div>';
}
if(isset($infos)) {
	echo '<div class="report infos"><p>Informations&nbsp;:<ul>';
	foreach($infos as $inf) { echo '<li>'.$inf.'</li>'; };
	echo '</ul></div>';
}
