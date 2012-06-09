<?php

// CONFIG BDD SERVEUR

// Identifiants pour la base de données. Nécessaires pour la class BDD.
define('SQL_DSN', 'pgsql:dbname=dbnf17p095;host=tuxa.sme.utc;port=5432');
define('SQL_USERNAME_ADMIN', 'nf17p095'); // Connexion avec droits de UPDATE, SELECT, INSERT, DELETE
define('SQL_PASSWORD_ADMIN', 'gubeL3AB');
define('SQL_USERNAME_PUBLIC', 'nf17p095'); // Connexion avec droits de SELECT
define('SQL_PASSWORD_PUBLIC', 'gubeL3AB');