<?php
	
    class Users extends Mother
    {
        // METHODE CREATION NOUVEL UTILISATEUR
        public function register($infos)
        {
            extract($infos);

            $ip = $_SERVER['REMOTE_ADDR'];
            $id_rank = getRank($rank);

            $query1 = "INSERT INTO `users`(`user_rank_id`,
                                           `login`,
                                           `password`,
                                           `email`,
                                           `ipv4`,
                                           `email_key`,
                                           `active`) 
                      VALUES (?,?,?,?,?,?,?)";

            $param1 = array($id_rank,
                            $login,
                            hashedString($password),
                            $email,
                            $ip,
                            $email_key,
                            "0"
            );

            myQuery($query1, 'insert', $param1);
        }
		
		// METHODE POUR CHECK LA DISPO DU LOGIN
		public function checkAvailableLogin($post){
			$query = "SELECT `login` FROM `users` WHERE `login`= :login";
			
			$param = array(":login" =>$post['login']);
					  
			$nb=myQuery($query,'select',$param,'count');
			return $nb;
		}
		
		public function checkAvailableEmail($post){
			$query = "SELECT `email` FROM `users` WHERE `email`= :email";
			
			$param = array(":email" =>$post['email']);
					  
			$nb=myQuery($query,'select',$param,'count');
			return $nb;
		}

        // METHODE QUI ACTIVE COMPTE VIA CLE
        public function activateAccount($email_key)
        {
            $query = "UPDATE `users` SET `active` = :active 
                      WHERE `email_key` = :email_key";

            $param = array(":active" => "1",
                           ":email_key" => $email_key
            );

            myQuery($query, "update", $param);
        }

        // METHODE DE SUPPRESSION D'UTILISATEUR
        public function deleteUser($id_user, $infos)
        {
            $query = "UPDATE `users` SET `active` = :active
                      WHERE `id` = :id";

            $param = array(":active" => "0",
                            "id" => $id_user
            );

            myQuery($query, "update", $param);

            if ($infos['del_content'] == 'oui')
                parent::deleteMedia(NULL, 'user', $id_user);
        }

        // METHODE CREATION NOUVELLE TEAM
        public function newTeam($infos, $id_user)
        {
            extract($infos);

            $queryI = "INSERT INTO `teams`(`name`,`id_user`) VALUES (?,?)";
            $paramI = array($name,
                            $id_user
            );

            myQuery($queryI, 'insert', $paramI);

            $id_team = getId($name, 'team');
            $queryU = "UPDATE `users` SET `team_id` = :id_team 
                       WHERE `id` = :id_user";

            $paramU = array(":id_team" => $id_team,
                            "id_user" => $id_user
            );

            myQuery($queryU, 'update', $paramU);
        }

        // METHODE DE SUPPRESSION DE TEAM
        public function deleteTeam($infos, $id_team)
        {
            $query = "UPDATE `teams` SET `active` = :active 
                      WHERE `id` = :id";

            $param = array("active" => "0",
                           ":id" => $id_team
            );

            myQuery($query, 'update', $param);

            if ($infos['del_content'] == 'oui')
                parent::deleteMedia(NULL, 'team', $id_team);
        }

        // -- HERITAGE METHODE MERE-- METHODE POUR ACTIVER/REACTIVER UN COMPTE OU UNE TEAM
        public function activateMe($name, $type)
        {
            parent::activateMe($name, $type);
        }

    	// METHODE VERIFIANT LA CONNECTION D'UN UTILISATEUR
    	public function checkUserLogin($infos)
    	{
      		extract($infos);
      
      		$query = "SELECT `id` 
                      FROM `users` 
                      WHERE `password` = :password AND (`login` = :login OR `email` = :login)";

      		$param = array(':login' => $login, 
                           ':password' => stringHashed($password)
            );

      		$check = myQuery($query, 'select', $param, 'count');
            $data = myQuery($query, 'select', $param, 'assoc');
      
      		if ($check > 0)
      			return $data;
      		else
      			return FALSE;
      	}

        // --HERITAGE METHODE MERE-- METHODE DE RECUPERARION D'INFO PROFIL
        public function getInfos($name, $type)
        {
            $data = parent::getInfos($name, $type);

            return ($data);
        }

        // METHODE D'UPDATE DU PROFIL
        public function updateInfos($infos, $type)
        {
            extract($infos);

            if ($type == 'user')
            {
                $id = getId($login);
                $query = "UPDATE `users` u,`users_infos` ui SET u.`email` = :email,
                                                                u.`login` = :login,
                                                                ui`lastname` = :nom,
                                                                ui`firstname` = :prenom,
                                                                ui`adress` = :adresse,
                                                                ui`zip_code` = :code_postal,
                                                                ui`city` = :ville,
                                                                ui.`phone` = :tel,
                                                                ui.`country` = :pays,
                                                                ui.`updated` = :updated 
                          WHERE `id` = :id";

                $param = array(":email" => $email,
                               ":login" => $login,
                               ":lastname" => $nom,
                               ":fisrtname" => $prenom,
                               ":adress" => $adresse,
                               ":zip_code" => $code_postal,
                               ":city" => $ville,
                               ":phone" => $tel,
                               ":pays" => $pays,
                               ":updated" => $updated,
                               ":id" => $id
                );
            }
            elseif ($type == 'team')
            {
                $query = "UPDATE `teams` SET `name` = :nom,
                                             `id_user` = :id_user,
                                             `updated` = :date_modif 
                          WHERE `id` = :id";

                $param = array(":name" => $nom,
                               ":id_user" => $id_user,
                               ":date_modif" => $date_modif,
                               ":id_user" => $id
                );
            }

            myQuery($query, 'update', $param);
        }
    }

?>