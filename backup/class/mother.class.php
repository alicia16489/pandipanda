<?php

	class Mother
	{
		private $_attribute;

	    // METHODE DE RECUPERARION D'INFO PROFIL
	    public function getInfos($name, $type)
	    {
	        if ($type == 'user')
	        {
	            $id = getId($name, 'user');
	            $query = "SELECT * FROM `users`,`users_infos` WHERE `users`.`id` = :id";
	            $param = array(":id" => $id);
	        }
	        // elseif ($type == 'team')
	        // {
	        //     $id = getId($name, 'team');
	        //     $query = "SELECT t.`name`,t.`active`,u.`login` FROM `teams` t,`users` u WHERE t.`id` = :id";
	        //     $param = array(":id" => $id);
	        // }

	        $data = myQuery($query, 'select', $param, 'assoc');

	        return ($data);
	    }

        // METHODE POUR ACTIVER/REACTIVER UN/DES COMPTE(S) OU UNE/DES TEAM(S)
        public function activateMe($name, $type)
        {
            if ($type == 'user')
            {
                if (is_array($name))
                {
                    foreach ($name as $value)
                    {
                        $id = getId($value, 'user');
                        $query = "UPDATE `users` SET `active` = :active WHERE `id` = :id";
                        $param = array(":active" => "1",
                                       ":id" => $id
                        );

                        myQuery($query, 'update', $param);
                    }
                }
                else
                {
                    $id = getId($name, 'user');
                    $query = "UPDATE `users` SET `active` = :active WHERE `id` = :id";
                    $param = array(":active" => "1",
                                   ":id" => $id
                    );

                    myQuery($query, 'update', $param);
                }

            }
            elseif ($type == 'team')
            {
                if (is_array($name))
                {
                    foreach ($name as $value)
                    {
                        $id = getId($value, 'team');
                        $query = "UPDATE `teams` SET `active` = :active WHERE `id` = :id";
                        $param = array(":active" => "1",
                                       ":id" => $id
                        );

                        myQuery($query, 'update', $param);
                    }
                }
                else
                {
                    $id = getId($name, 'team');
                    $query = "UPDATE `teams` SET `active` = :active WHERE `id` = :id";
                    $param = array(":active" => "1",
                                   ":id" => $id
                    );

                    myQuery($query, 'update', $param);
                }
            }
        }

		// METHODE QUI SUPPRIME LE/LES CONTENU(S)
		public function deleteMedia($file = NULL, $type = NULL, $id = NULL)
		{
			if (is_null($type) && is_null($id) && !is_null($file))
			{
				if (is_array($file)) // delete multicontenus
				{
					foreach ($file as $value)
					{
						$query = "DELETE FROM `medias` WHERE `login` = :name";
						$param = array(":name" => $value);

						myQuery($query, "delete", $param);
					}
				}
				else
				{
					$query = "DELETE FROM `medias` WHERE `login` = :name";
					$param = array(":name" => $name);

					myQuery($query, "delete", $param);
				}
			}
			elseif ($type == 'user')
			{
				$query = "DELETE FROM `medias` WHERE `id_user` = :id_user";
	            $param = array(":id_user" => $id);

	            myQuery($query, 'delete', $param);
			}
			elseif ($type == 'team')
			{
				$query = "DELETE FROM `medias` WHERE `id_team` = :id_team";
	            $param = array(":id_team" => $id);

	            myQuery($query, 'delete', $param);
			}
		}
	}

?>