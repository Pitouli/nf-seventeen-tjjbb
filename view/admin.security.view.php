<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="none" />
<title><?php echo BROWSER_SITE_TITLE.' - Administration'?></title>
<?php require 'style/style.php' ?>
</head>
<body>
<div id="minPage">

<?php require DIR_INC.'admin.report.inc.php' ?>

<div>
    <h1>Identification</h1>
    <form method="post" action="">
    <table class="minTable">
      <tr>
        <td>Pseudo&nbsp;:</td>
        <td><input name="pseudo" type="text" />&nbsp;</td>
      </tr>
      <tr>
        <td>Mot de passe&nbsp;:</td>
        <td><input type="password" name="password" /></td>
      </tr>
      <tr>
        <td colspan="2"><input type="checkbox" name="rememberme" id="rememberme" /><label for="rememberme">&nbsp;se souvenir de moi</label>
        </td>
      </tr>
      <tr>
        <td colspan="2"><a href="<?php echo ROOT ?>gallery.html">Retour à la galerie</a> - <input type="submit" value="Se connecter" /></td>
      </tr>
    </table>
    </form>    
</div>
</div>
<?php require 'js/js.php' ?>
</body>
</html>