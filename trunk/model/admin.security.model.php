<?php

// Si l'utilisateur n'est pas identifié comme administrateur
if(!isset($_SESSION['usr_status']) || $_SESSION['usr_status'] != 'admin')
{
	$getInfosUsr = $bdd->prepare("SELECT * FROM users WHERE pseudo = :pseudo AND password = :password LIMIT 1");
	
	// Si l'utilisateur a sauvegardé ses identifiants dans un cookie
	if(isset($_COOKIE['pseudo']) && isset($_COOKIE['password']))
	{
		$getInfosUsr->execute(array(':pseudo' => $_COOKIE['pseudo'], ':password' => $_COOKIE['password']));
		$infosUsr = $getInfosUsr->fetch();
		
		if($infosUsr != NULL)
			{
				$_SESSION['usr_pseudo'] = $infosUsr['pseudo'];
				$_SESSION['usr_status'] = $infosUsr['status'];
				$infos[] = "Heureux de vous voir de retour sur le site !";
			}
		else
			{
				$_SESSION['usr_status'] = NULL;
				// On supprime les cookies en les écrivant dans le passé (01 javier 1970 et 42 secondes)
				setcookie('pseudo', 0, 42, '/');
				setcookie('password', 0, 42, '/');
			}
	}
	// Si l'utilisateur a utilisé le formulaire
	elseif(isset($_POST['pseudo']) && isset($_POST['password']))
	{
		$getInfosUsr->execute(array(':pseudo' => $_POST['pseudo'], ':password' => md5($_POST['password'])));
		$infosUsr = $getInfosUsr->fetch();		
		
		if($infosUsr != NULL)
			{
				$_SESSION['usr_pseudo'] = $infosUsr['pseudo'];
				$_SESSION['usr_status'] = $infosUsr['status'];
				
				if(isset($_POST['rememberme']) && $_POST['rememberme'] == 'on')
				{
					setcookie('pseudo', $_POST['pseudo'], time()+3600*24*30, '/');
					setcookie('password', md5($_POST['password']), time()+3600*24*30, '/');
				}
			}
		else
			{
				$_SESSION['usr_status'] = NULL;
				$errors[] = "Votre pseudo ou votre mot de passe n'est pas valide. Veuillez réessayer";
			}
	}
	// Si l'utilisateur n'a ni cookie ni utilisé le formulaire
	else
	{
		$_SESSION['usr_status'] = NULL;
	}
}