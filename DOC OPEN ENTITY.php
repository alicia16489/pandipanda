<?php

exit() ; // Sécurisation de la Doc.
	
	DOC OPEN ENTITY

	Class mère : "class/mother.class.php"
	{
		public function getInfos($name, $type): récupère les infos dun utilisateurs, team ou media.
		paramètres :
			$name => nom du user ou nom dune team ou dun media.
			$type => $type = 'user' ou 'media' ou 'team'.
		return :
			renvoie un tableau associatif des informations dans la table `users` et `users_infos`.

		public function activateMe($name, $type): active le compte dun utilisateur, team ou media
		paramètre :
			$name => nom du user ou nom dune team ou dun media.
			$type => $type = 'user' ou 'media' ou 'team'.
		particularité : 
			si $name est un tableau avec plus dune case(ex: un $_POST qui coche plusieurs users)
			cela implique la multiactivation de compte.
		return :
			aucun

		public function deleteMedia($file = NULL, $type = NULL, $id = NULL) supprime un ou plusieurs medias dun user ou le contenu total si le compte est détruit.
		paramètre :
			$file => nom du fichier a supprimer.
			$all => supprime tout le contenu dun poste si TRUE
			$type => 'user' ou 'team'.
			$name => nom de lutilisateur ou de la team.
		return :
			aucun
	}

	function tool() : "includes/tools.php"
	{
		function myQuery($query, $query_type = NULL, $param = NULL, $return_type = NULL) execute en requete en PDO
		paramètre :
			$query => la requete préparée ou non.
			$query_type => le type de query (ex: 'select' ou 'delete').
			$param => si la requete est préparée indiqué dans un tableau les parametres de la requete
			$return_type => si de $query_type = 'select' indiqué un return type : 
				'assoc' pour un tableau associatif.
				'count' pour un entier. (nombre de colonne);
		return :
			si $return_type indiqué renvoie un tableau associatif ou un entier sinon aucun.

		function qrRand($nb) génère une string aléatoire.
		paramètre :
			$nb => nombre entier (précise la taille de la chaine retourné);
		return :
			la chaine généré;

		function makeMeAKey($keyType) demande explication a BENOIT CIRET merci.
		paramètre :
			$keyType => .
		return :
			???

		function getId($name, $type) récupère un id pour un user, team, media
		paramètre :
			$name => nom du user ou nom dune team ou dun media.
			$type => $type = 'user' ou 'media' ou 'team'.
		return :
			un entier dun ID.

		function stringCheck($string, $sizeMin, $sizeMax, $type = NULL) check la mis en forme dune string
		paramètre :
			$string => la chaine à vérifié.
			$sizeMin => la taille minimum quelle doit avoir.
			$sizeMax => la taille max quelle doit avoir.
			$type => si elle doit etre 'alpha', 'digit', 'alphanum'.
		return :
			TRUE si la chaine respecte les paramètres. Sinon FALSE.

		function stringHash($string, $suffixe = FALSE) Hash une chaine de caractère en sha256
		paramètre :
			$string => la string à hasher.
			$suffixe => concaténation d un suffixe de résistance aux dictionnaires sha en cas de comprommission de la base. Si = FALSE, aucun suffixe n est utilise. La variable $config['sha'] contient le suffixe classique utilisé sur la plateforme de prod.
		return :
			la chaine hashée.

		function pre($var, $die = FALSE) deroule le contenu dun tableau
		paramètre :
			$var : le tableau a derouler
			$die :  TRUE si vous voulez executer un die() apres laffichage du tableau.
		return :
			aucun

		function checkIfActive($id, $type) vérifie si un user, team ou media est activité
		paramètre :
			$id => lid de la chose a checker
			$type => 'user', 'team' ou 'media'.
		return :
			return 0 si inactif ou 1 si actif

		function getRank($rank) récupère lid du rang utilisateur
		
		function jsLibrairies($nom_librairie, $version)
			echo // la librairie javascript récalmée dans le head html. Possibilité de choisir la version désirée. Par défault, l'array $config['js-libs'] contient les versions utilisées et est configuarable dans config.php
	}
