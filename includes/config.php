<?php

	// CONFIG DE LA BDD
	$DNS = 'mysql:host=localhost;dbname=openentity';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_OPT = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
  					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  	);

	// CONFIG DES ACTIONS
	$config['routes'] = array(
							'home' => 'media',
							'media_search' => 'media',
							'post_content' => 'media',
							
							// user life
							'register' => 'user',
							'login' => 'user',
							
							'disconnect' => 'user',
							
							// user control
							'admin_panel' => 'user',
							'activate_profil' => 'user',
							'reactivate_profil' => 'user',
							
							
	);
	
	// array filtre
	$out_words = array ("le","la","lu","lo","ly","un","une","des","les");

	// ACTION PAR DEFAUT
	$config['default']['action'] = "home";
	
	// setup
	$user_setup='./includes/setups/user.setup.php';

	// EXTENSIONS D'UPLOAD AUTORISEES
	$config['extension'] = array("jpeg", 
                                 "jpg",
                                 "jpe",
                                 "gif",
                                 "png",
                                 "mp3",
								 "wma",
								 "flv",
								 "wav"
								 
    );

	$path = "./files/";
?>