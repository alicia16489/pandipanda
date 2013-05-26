<?php
	//setup
	session_start();
	date_default_timezone_set("Europe/Paris"); // set date default timezone
	header('Content-Type: text/html; charset=UTF-8'); //encode
	include ('./includes/config.php');
	include ('./includes/tools.php');
	spl_autoload_register('downloadClass');
	
	// bdd connect
	$link = connectBDD($DNS, $DB_USER, $DB_PASS);
	
	// default action & template
	$action = $config['default']['action'];
	$template_main = $action;
	$template_left=null;
	
	// get
	if (!empty($_GET['action']))
		$action = $_GET['action'];

	
	// action control
	if (!array_key_exists($action, $config['routes']))
		die ("L'action demand&eacute;e n'existe pas. <br /> <a href='index.php'>retour &agrave; l'accueil</a>");
		

	// rooter action with file control
	include($route=route($action));

	// main view : template including
	include ("views/main.view.php");

?>