<?php

	// CONFIG DE LA BDD
	$DNS = 'mysql:host=localhost;dbname=openentity;charset=utf8';
	$DB_USER = 'root';
	$DB_PASS = '';

	// CONFIG DES ACTIONS
	$config['routes'] = array(
							'home' => 'media',
							'media_search' => 'media',
							'upload_content' => 'media',
							
							// user life
							'register' => 'user',
							'login' => 'user',
							
							'disconnect' => 'user',
							
							// user control
							'edit_profil' => 'user',
							'del_profil' => 'user',
							'activate_profil' => 'user',
							'reactivate_profil' => 'user',
							
							
	);
	
	// array filtre
	$out_words=array ("le","la","lu","lo","ly","un","une","des","les");

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