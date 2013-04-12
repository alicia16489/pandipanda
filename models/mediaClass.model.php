<?php
	
	class Medias extends Mother
	{
		// METHODE QUI CREE LE DOSSIER OU SERONT STOCKE LES FILES D'UN USER
		public function createDir($name)
		{
			global $path;

			mkdir($path.stringHash($name));
		}

		// METHODE DE POST DE CONTENU IMG ET AUDIO ET BD
		public function uploadMedia($dest, $file, $max_size, $name, $extension)
		{
			if (stringCheck($name, 3, 32, 'alpha') == TRUE)
			{
				if ($file['error'] == 0) // on vérifie si les erreurs en rapport au fichier sont absentes
				{
					if ($file['size'] < $max_size) // on vérifie si la taille est pas trop grosse
					{
						$file_ini = pathinfo($file['name']); // on récupère les infos fichiers
						$file_ext = strtolower($file_ini['extension']); // on chope l'extension

						if (in_array($file_ext, $extension))  // on vérifie que l'extension est bien présente dans le tableau de celles autorisées
						{
						    $dest = $path;
					    	$new_name = $name.".".$file_ext;

				   			if (move_uploaded_file($file["tmp_name"], $dest.'/'.$new_name)) // on bouge le fichier de son dossier temporaire pour le bouger 
				    			return TRUE;
					    }
					    else
					    	return FALSE;
					}
					else
				    	return FALSE;
				}
				else
			    	return FALSE;
			}
			else
				return FALSE;
		}

		// METHODE D'ACTIVATION DE CONTENUE
		public function activateMedia($name)
		{
	        if (is_array($name))
	        {
	            foreach ($name as $value)
	            {
	                $id = getId($value, 'media');
	                $query = "UPDATE `medias` SET `active` = :active WHERE `id` = :id";
	                $param = array(":active" => "1",
	                               ":id" => $id
	                );

	                myQuery($query, 'update', $param);
	            }
	        }
	        else
	        {
	            $id = getId($name, 'media');
	            $query = "UPDATE `medias` SET `active` = :active WHERE `id` = :id";
	            $param = array(":active" => "1",
	                           ":id" => $id
	            );
	            
	            myQuery($query, 'update', $param);
	        }
		}

		// METHODE QUI SUPPRIME LE/LES CONTENU(S)
		public function deleteMedia($file = NULL, $type = NULL, $id = NULL)
		{
			if (is_null($type) && is_null($id) && !is_null($file))
			{
				parent::deleteMedia($file);
			}
			elseif ($type == 'user')
			{
				parent::deleteMedia(NULL, $type, $id);
			}
			elseif ($type == 'team')
			{
				parent::deleteMedia(NULL, $type, $id);
			}
		}

		// METHODE D'ENREGISTREMENT EN BDD DES POST
		public function insertMedia($infos, $file == NULL, $team = NULL)
		{
			extract($infos);

			if (!is_null($file))
			{
				$file_ini = pathinfo($file['name']);

				if (empty($name))
					$name = $file_ini['filename']; // name sans l'extension
			}

			if (is_null($team))
			{
				if (!empty($link))
				{
					$query = "INSERT INTO `medias`(`title`,
												   `type`,
												   `tag`,
												   `resum`)  
							  VALUES (?,?,?,?,?,?,?)";

					$param = array($title,
							  	   $type,
							   	   $tag,
							       $resum,
							       $link
					);
				}
				else
				{
					$query = "INSERT INTO `medias`(`title`,
												   `type`,
												   `tag`,
											       `resum`,
												   `size`) 
							  VALUES (?,?,?,?,?,?)";

					$param = array($title,
								   $type,
								   $tag,
								   $resum
					);
				}
			}
			else
			{
				if (!empty($link))
				{
					$query = "INSERT INTO `medias`(`title`,
												   `type`,
												   `tag`,
												   `resum`) 
							  VALUES (?,?,?,?,?,?,?)";

					$param = array($title,
							  	   $type,
							   	   $tag,
							       $description,
							       $link
					);
				}
				else
				{
					$query = "INSERT INTO `medias`(`title`,
												   `type`,
												   `tag`,
												   `resum`) 
							  VALUES (?,?,?,?,?,?)";

					$param = array($title,
								   $type,
								   $tag,
								   $description,
					);
				}
			}

			myQuery($query, 'insert', $param);
		}
	}

?>