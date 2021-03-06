<?php
	function include_template($template){
		// VERIFIE L'EXISTENCE DES VUES
			$template_path = './templates/'.$template.'.template.php';

			if (is_readable($template_path) && file_exists($template_path))
				return $template_path;
			else
				die ('Page '.$template_path.' inexistant ou innaccessible <br /> <a href="index.php">retour &agrave; l\'accueil</a>');

	}
	
	function filtre($string,$delimiter){
		global $out_words;
		$string = str_replace("'"," ",$string);
		$words = explode($delimiter,$string);
		$keywords = array();
			
		foreach($words as $word){
			if(!in_array($word,$out_words) && strlen($word) > 2){
				$keywords[]=$word;
			}
		}
		
		return $keywords;
	}

	function route($action){
		global $config;
	
		$actiongroups = 'actiongroups/'.$config['routes'][$action].'.controller.php';
		if (is_readable($actiongroups))
			return $actiongroups;
		else
			die ('Le fichier '.$actiongroups.' n\'existe pas ou est innaccessible');
	}

	// FONCTION D'AUTOCHARGEMENT DES CLASSES
	function downloadClass($class)
	{
		require('class/'.$class.'.class.php');
	}

	// FONCTION DE CONNECTION A LA BDD
	function connectBDD($DNS, $DB_USER, $DB_PASS, $DB_OPT)
	{
		try
		{
	        $link = new PDO($DNS, $DB_USER, $DB_PASS, $DB_OPT);
	    }
		  
		catch(PDOException $e)
		{
			echo 'Erreur : '.$e->getMessage().'<br />';
	        echo 'N° : '.$e->getCode().'<br />';
	        echo 'La connexion &agrave; la BDD a &eacute;chou&eacute;e!';
	        die();
		}

		return ($link);
	}

	// FONCTION REQUETE
	function myQuery($query, $query_type = NULL, $param = NULL, $return_type = NULL){
   		global $link;
	   	$sql = $link->prepare($query);

	   	if (!is_null($param)){
	   		$result = $sql->execute($param);
		}
	   	else{
	   		$result = $sql->execute();
		}
		if(!$result){
			print_r($sql->errorInfo());
			return false;
		}
	   	if ($query_type == 'select')
	   	{
	   		switch ($return_type)
	   		{
	    		case 'count':
		    		$data = $sql->rowCount();
		    	break;
	    		case 'assoc':
	     			if(($sql->rowCount()) == 1)
	      				$data = $sql->fetch(PDO::FETCH_ASSOC);
	     			else
	      				$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	    		break;
	   		}

	   		if ($result)
	    		return $data;
	   	}
		return true;
   	}

	// //-- EMAIL CHECK --//
	// --> use this: if (!filter_var($email, FILTER_VAR_EMAIL)) :thumbs: 
	// //-- EMAIL CHECK --//

	//-- LETTER GENERATOR --//
	function qrRand($nb)
	{
	    $r = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $t = "";

	    for ($j = 0; $j < $nb; $j++)
	    {
	    	$i = rand(0,35);
	    	$t .= $r[$i];
	    }

	    return $t;
	}
	//-- LETTER GENERATOR --//
		
	//-- KEYGENERATOR --//
	function makeMeAKey(){
			$key = qrRand(6);
			$query = "SELECT `email_key` FROM `users` WHERE `email_key` = :email_key";
			$param = array(':email_key' => $key);

			while(myQuery($query,'select', $param, 'assoc')){
				$key = qrRand(6);
			}

			return $key;
	}

	// FONCTION POUR RECUPERER USER OU MEDIA ID
	function getId($name, $type)
	{
		if ($type == 'user')
			$query = "SELECT `id` FROM `users` WHERE `login` = :name";
		elseif ($type = 'media')
			$query = "SELECT `id` FROM `medias` WHERE `title` = :name";

		$param = array(":name" => $name);

		$data = myQuery($query, 'select', $param, 'assoc');

		return ($data['id']);
	}

	// FONCTION POUR RECUPERER Id KEYWORD
	function getKeywordId($name)
	{
		$query = "SELECT `id` FROM `keywords` WHERE `name` = :name";
		$param = array(':name' => $name);
		$data = myQuery($query, 'select', $param, 'assoc');

		return ($data['id']);
	}

	//-- STRING CHECK --//
	function stringCheck($string, $type = NULL, $sizeMin = NULL, $sizeMax = NULL)
	{
		if ($type == 'alpha')
		{//alpha
			if(ctype_alpha($string))
			{
				if(strlen($string) >= $sizeMin && strlen($string) <= $sizeMax)
					return TRUE;
				else
					return FALSE;
			}
			else
				return FALSE;
		}
		elseif ($type == 'digit')
		{//digit
			if(ctype_digit($string))
			{
				if(strlen($string) >= $sizeMin && strlen($string) <= $sizeMax)
					return TRUE;
				else
					return FALSE;
			}
			else
				return FALSE;
		}
		elseif ($type == 'alphanum')
		{
			if(ctype_alnum($string))
			{
				if(strlen($string) >= $sizeMin && strlen($string) <= $sizeMax)
					return TRUE;
				else
					return FALSE;
			}
			else
				return FALSE;
		}
		else
		{//other (password)
			if(strlen($string) >= $sizeMin && strlen($string) <= $sizeMax)
				return TRUE;
			else
				return FALSE;
		}
		
	}
	//-- STRING CHECK --//
		
		
	//-- STRING HASH --//
	function stringHash($string)
	{
		$hashedString = hash("sha256", $string);
		
		return ($hashedString);
	}
	//-- STRING HASH --//

	// FONCTION DEBUG
	function pre($var, $die = FALSE)
	{
		echo ('<pre>');
		print_r ($var);
		echo ('</pre>');

		if ($die == TRUE)
			die();
	}

	// FONCTION QUI CHECK L'ACTIVE D'UN COMPTE OU TEAM OU media
	function checkIfActive($id, $type)
	{
		if ($type == 'user')
			$query = "SELECT `active` FROM `users` WHERE `id` = :id";
		elseif ($type == 'team')
			$query = "SELECT `active` FROM `teams` WHERE `id` = :id";
		elseif ($type == 'media')
			$query = "SELECT `active` FROM `medias` WHERE `id` = :id";

		$param = array(":id" => $id);

		$data = myQuery($query, 'select', $param, 'assoc');

		return ($data);
	}

	// FONCTION QUI RECUP ID RANK USER
	function getRank($rank)
	{
		$query = "SELECT `id` FROM `users_rank` WHERE `name` = :name";
		$param = array('name' => $rank);

		$data = myQuery($query, 'select', $param, 'count');

		return ($data);
	}

?>