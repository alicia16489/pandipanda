<?php

	// CONFIG DE LA BDD
	$DNS = 'mysql:host=localhost;dbname=openentity';
	$DB_USER = 'root';
	$DB_PASS = '';
	
	// Suffixe de securisation sha en cas de compromission de la BDD
	$config['sha'] = 'sqb7ndkdj4eprd558dz4' ;

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
	
	// VERSION DES LIBS JS DESIREES
	$config['js-libs'] = array(	'jquery' => 	'2.0.0',
								'jquery-ui' => 	'1.10.3'
							);
?>