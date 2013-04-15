<?php
	// DEMARRAGE DE LA SESSION
	session_start();
	
	include ('./includes/config.php');
	include ('./includes/tools.php');
	
	// AUTO-LLOAD DES CLASS
	spl_autoload_register('downloadClass');

	$link = connectBDD($DNS, $DB_USER, $DB_PASS);
	
	$action = $_POST['action'];
	$post = $_POST['post'];
	$elem = $_POST['elem'];
	
	// VERIFICATION EXISTENCE DE L'ACTION DANS LA CONFIG
	if (!array_key_exists($action, $config['routes']))
		die ("L'action demand&eacute;e n'existe pas. <br /> <a href='index.php'>retour &agrave; l'accueil</a>");

	// APPEL DU SOUS-CONTROLLER
	$actiongroups = 'actiongroups/'.$config['routes'][$action].'.controller.php';
	if (is_readable($actiongroups))
		include ($actiongroups);
	else
		die ('Le fichier '.$actiongroups.' n\'existe pas ou est innaccessible');
		
		
	include('./views/ajax.view.php');
?>