<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo BROWSER_SITE_TITLE ?> | Connexion</title>
<?php require DIR_STYLE.'style.php' ?>
</head>
<body>
<div id="minPage">
<?php require DIR_INC.'report.inc.php' ?>

<div>
    <h1>Identification</h1>
    <form method="post" action="">
    <table class="minTable">
      <tr>
        <td><label for="password">Mot de passe&nbsp;:</label></td>
        <td><input type="password" name="password" /></td>
      </tr>
      <tr>
        <td colspan="2"><input type="checkbox" name="rememberme" id="rememberme" /><label for="rememberme">&nbsp;se souvenir de moi</label>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Se connecter" /></td>
      </tr>
    </table>
    </form>    
</div>

</div>
<?php require 'js/js.php' ?>
</body>
</html>
