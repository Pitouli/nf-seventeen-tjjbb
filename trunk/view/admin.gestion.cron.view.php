<?php require DIR_INC.'admin.header.inc.php' ?>
<h1>Gestion des tâches automatiques</h1>

<?php require DIR_INC.'admin.report.inc.php' ?>

<div class="explain">
	<p>La gestion de ce site est en partie automatisée grâce à l'exécution automatique de divers scripts. On appelle ces tâches automatiques des <strong>crons</strong>.</p>
	<p>Sur cette page, on peut voir les différentes tâches, leur fréquence d'éxecution, leur état (activée ou non), etc.</p>
<p>Si besoin, on peut lancer manuellement une tâche (par exemple si on veut procéder à la suppression immédiate de photos). <strong>Lors d'une éxécution manuelle de la tâche, il est primordial pour la stabilité du site de ne pas arrêter le script une fois lancé (càd de ne pas fermer la fenêtre qui s'est ouverte) jusqu'à tant que son exécution se soit terminée. Les scripts sont prévus pour s'arrêter automatiquement après 30 secondes au plus. Un message de confirmation de fin de tâche s'affichera.</strong></p>
	<p>Les scripts coûtent 0.0001€/éxécution. Le script CheckCron se charge d'activer/désactiver les autres scriptss quand nécessaire.</p>
</div>

<div class="corps">
  <table class="largeTable">
    <tr>
      <td><strong>Nom</strong></td>
      <td><strong>Description</strong></td>
      <td><strong>Fréquence</strong></td>
      <td><strong>Etat</strong></td>
      <td><strong>Actions</strong></td>
    </tr>
    <tr>
      <td>Stock2Gal</td>
      <td>Ajoute les photos importées dans la galerie</td>
      <td>5 min</td>
      <td><?php echo $cronStatus['stock2gal']; ?></td>
      <td><a href="<?php echo ROOT ?>cron/stock2gal,usrAdmin.html">Exécuter</a></td>
    </tr>
    <tr>
      <td>RegeMin</td>
      <td>Recrée les miniatures des photos concernées</td>
      <td>2 min</td>
      <td><?php echo $cronStatus['regeMin']; ?></td>
      <td><a href="<?php echo ROOT ?>cron/regeMin,usrAdmin.html">Exécuter</a></td>
    </tr>
    <tr>
      <td>Suppr</td>
      <td>Supprime définitivement les photos et pièces-jointes concernées</td>
      <td>1 jour</td>
      <td><?php echo $cronStatus['suppr']; ?></td>
      <td><a href="<?php echo ROOT ?>cron/suppr,usrAdmin.html">Exécuter</a></td>
    </tr>
    <tr>
      <td>CheckCron</td>
      <td>Active/Désactive les autres crons selon le contexte</td>
      <td>8 heures</td>
      <td><?php echo $cronStatus['checkCron']; ?></td>
      <td><a href="<?php echo ROOT ?>cron/checkCron,usrAdmin.html">Exécuter</a></td>
    </tr>
  </table>
  <p><strong>Crédit restant : <?php echo $credits; ?> €</strong></p>
</div>

<?php require DIR_INC.'admin.footer.inc.php' ?>