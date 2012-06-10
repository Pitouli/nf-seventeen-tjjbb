<?php

// Si l'utilisateur n'est pas identifié comme administrateur
if(!isset($_SESSION['connected']) || !$_SESSION['connected'])
{
	// Si l'utilisateur a sauvegardé ses identifiants dans un cookie
	if(isset($_COOKIE['password']))
	{		
		if($_COOKIE['password'] == md5(PASSWORD))
			{
				$_SESSION['connected'] = true;
				$infos[] = "Heureux de vous voir de retour sur le site !";
			}
		else
			{
				$_SESSION['connected'] = false;
				// On supprime les cookies en les écrivant dans le passé (01 javier 1970 et 42 secondes)
				setcookie('password', 0, 42, '/');
			}
	}
	// Si l'utilisateur a utilisé le formulaire
	elseif(isset($_POST['password']))
	{		
		if(!isset($_SESSION['tried']) || $_SESSION['tried'] <= CONNECTION_TRY)
		{		
			if($_POST['password'] == PASSWORD)
			{
				$_SESSION['connected'] = true;
				$_SESSION['tried'] = 0;
				
				if(isset($_POST['rememberme']) && $_POST['rememberme'] == 'on')
				{
					setcookie('password', md5($_POST['password']), time()+3600*24*30, '/');
				}
			}
			else
			{
				$_SESSION['connected'] = false;
				isset($_SESSION['tried']) ? $_SESSION['tried']++ : $_SESSION['tried'] = 1; // On compte un essai de plus
				$left_tried = CONNECTION_TRY-$_SESSION['tried'];
				$errors[] = "Le mot de passe n'est pas valide. Veuillez réessayer (".$left_tried." essais restants)";
			}			
		}
		else
		{
			$_SESSION['connected'] = false;
			$errors[] = "Vous avez épuisés votre nombre d'essais autorisés pour vous connecter. Contactez votre administrateur réseau.";
		}
	}
	// Si l'utilisateur n'a ni cookie ni utilisé le formulaire
	else
	{
		$_SESSION['connected'] = false;
	}
}