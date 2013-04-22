<?php
	
	// DEMARRAGE DE LA SESSION
	session_start();

	include ('includes/config.php');
	include ('includes/tools.php');
	
	// AUTO-LLOAD DES CLASS
	spl_autoload_register('downloadClass');

	$link = connectBDD($DNS, $DB_USER, $DB_PASS);
	
	// VALEUR DE LA PAGE PAR DEFAUT
	$action = $config['default']['action'];
	
	// ROUTER SI ACTION EN URL
	if (!empty($_GET['action']))
		$action = $_GET['action'];
	
	// DEFINITION DU TEMPLATE PAR DEFAUT
	$template = $action;

	// VERIFICATION EXISTENCE DE L'ACTION DANS LA CONFIG
	if (!array_key_exists($action, $config['routes']))
		die ("L'action demand&eacute;e n'existe pas. <br /> <a href='index.php'>retour &agrave; l'accueil</a>");

	// APPEL DU SOUS-CONTROLLER
	$actiongroups = 'actiongroups/'.$config['routes'][$action].'.controller.php';
	if (is_readable($actiongroups))
		include ($actiongroups);
	else
		die ('Le fichier '.$actiongroups.' n\'existe pas ou est innaccessible');

	// APPEL DE LA VUE
	include ("views/main.view.php");

?>