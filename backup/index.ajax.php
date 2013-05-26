<?php
	// DEMARRAGE DE LA SESSION
	session_start();
	header('Content-Type: text/html; charset=UTF-8'); //encode
	include ('./includes/config.php');
	include ('./includes/tools.php');
	
	// AUTO-LLOAD DES CLASS
	spl_autoload_register('downloadClass');

	$link = connectBDD($DNS, $DB_USER, $DB_PASS);
	
	$action = $_POST['action'];
	$post = $_POST['post'];
	if(isset($_POST['elem'])){
		$elem = $_POST['elem'];
	}
	if(isset($_POST['param'])){
		$param = $_POST['param'];
	}
	if(isset($_POST['order'])){
		$order = $_POST['order'];
	}
	if(isset($_POST['sens'])){
		$sens = $_POST['sens'];
	}
	
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