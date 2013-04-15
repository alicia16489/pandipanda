<?php

	// CONFIG DE LA BDD
	$DNS = 'mysql:host=localhost;dbname=openentity';
	$DB_USER = 'root';
	$DB_PASS = '';

	// CONFIG DES ACTIONS
	$config['routes'] = array('home' => 'user',
							  'register' => 'user',
							  'login' => 'user',
							  'disconnect' => 'user',
							  'activate_profil' => 'user',
							  'edit_profil' => 'user',
							  'del_profil' => 'user',
							  'reactivate_profil' => 'user',
							  'upload_content' => 'content',
							  'prod' => 'prod'
	);

	// ACTION PAR DEFAUT
	$config['default']['action'] = "prod";

	// TEMPLATE PAR DEFAUT
	$config['default']['template'] = "login";

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