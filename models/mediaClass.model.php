<?php
	
	class Media
	{
		public function getMediasBySearch($post)
		{
			$keywords = filtre($post['search'],' ');
			$id_keywords = array();
			$param = array();
			
			
			if (!empty($post['search']))
			{ 
				// get id from user keywords
				$query = "SELECT name,id FROM keywords a WHERE ";

				foreach($keywords as $key => $keyword)
				{
					if($key != 0)
					{
						$query .= " OR ";
					}
					$query .= "a.name = :".$keyword."";
					$param[":".$keyword] = $keyword;
				}

				$data = myQuery($query,'select',$param,'assoc');
			}
			
			// get medias from id keywords and filter
			$count = 0;
			$param = array();
			$query = "SELECT a.id, COUNT(a.id) 'nb_keywords', title, resum, active, c.name 'category', b.name 'type'
					  FROM  medias a 
					  LEFT JOIN media_types b ON a.media_types_id = b.id 
				   	  LEFT JOIN category c ON a.category_id = c.id ";

			if(!empty($post['search'])){
				$query .= "LEFT JOIN medias_has_keywords e ON a.id = e.medias_id ";
			}
			if($post['type'] != 0 || $post['category'] != 0 || !empty($post['search'])){
				$query .="WHERE ";
			}
			if($post['type'] != 0){ 
				$query .= "b.id=".$post['type'];
				$count++;
			}
			if($post['category'] != 0){ 
				if($count != 0){
					$query .= " AND ";
				}
				$query .= " c.id=".$post['category'];
				$count++;
			}
			if(!empty($post['search'])){ 
				if($count != 0){
					$query .= " AND ";
				}
				$query .= "(";
				if(isset($data[0])){
					foreach($data as $key => $keyword){
						if($key != 0){
							$query .= " OR ";
						}
						$query .= " e.keywords_id = :".$keyword['name'];
						$param[":".$keyword['name']] = $keyword['id'];
					}
					
				}
				else{
					$query .= " e.keywords_id = :".$data['name'];
					$param[":".$data['name']] = $data['id'];
				}
				$query .= ")";
				$count++;
				
			}
			$query .= " GROUP BY a.id";
			$query .= " ORDER BY COUNT(a.id) DESC, title";
			
			$data=myQuery($query,'select',$param,'assoc');
			
			if(isset($data[0]) && is_array($data[0])){
				foreach($data as $key => $row){
					$query="SELECT admin_labels_id 'id' FROM medias_has_admin_labels a WHERE a.medias_id=?";
					$param=array($row['id']);
					$result = myQuery($query,'select',$param,'assoc');
					foreach($result as $nb => $label){
						$data[$key]['label'][$nb]=$label;
					}
				}
			}
			else{
				$query="SELECT admin_labels_id 'id' FROM medias_has_admin_labels a WHERE a.medias_id=?";
				$param=array($data['id']);
				$result = myQuery($query,'select',$param,'assoc');
				
				foreach($result as $nb => $label){
					$data['labels']['label'][$nb]=$label;
				}
			}
			
			//print_r($data);
			$medias=array();
			// if labels choice exist
			if(isset($post['labels'])){
				foreach($data as $media){
					if(isset($media['label'])){
						foreach($media['label'] as $label){
							if(in_array($label['id'],$post['labels'])){
								$medias[]=$media;
							}
						}
					}
				}
				return $medias;
			}
			return $data;
		}

		// METHODE D'ENREGISTREMENT EN BDD DES POST
		public function insertMedia($infos, $files = NULL)
		{
			extract($infos);

			if ($media_type_id == 4)
			{
				$query = "INSERT INTO `medias`(`title`,
											   `media_types_id`,
											   `media_subtype`,
											   `resum`,
											   `active`) 
					  	  VALUES (?,?,?,?,?)";

				$param = array($title,
						  	   $media_type_id,
						  	   $media_sous_type_id,
						       $resum,
						       1
				);

				myQuery($query, 'insert', $param);
			}
			else
			{
				$query = "INSERT INTO `medias`(`title`,
										   	   `media_types_id`,
										   	   `category_id`,
										   	   `resum`,
										   	   `active`) 
					  	  VALUES (?,?,?,?,?)";

				$param = array($title,
						  	   $media_type_id,
						  	   $categorie_id,
						       $resum,
						       1
				);

				myQuery($query, 'insert', $param);
			}

			$id_media = getId($title, 'media');
			$id_user = $_SESSION['id_user'];

			$query1 = "INSERT INTO `medias_has_users` VALUES (?,?)";
			$param1 = array($id_media, $id_user);

			myQuery($query1, 'insert', $param1);

			
			if ($media_type_id == 1 || $media_type_id == 2)
			{
				$query2 = "INSERT INTO `contents`(`medias_id`,
												  `chapter_num`,
												  `chapter_name`,
											      `path`,
											      `hosted`) 
						   VALUES (?,?,?,?,?)";

				$param2 = array($id_media,
							    intval($chap_num),
							    $chap_title,
							    $link,
							    0
				);

				myQuery($query2, 'insert', $param2);
			}
			elseif ($media_type_id == 3)
			{
				$query2 = "INSERT INTO `contents`(`medias_id`,
												  `chapter_num`,
												  `chapter_name`,
											      `content`,
											      `hosted`) 
						   VALUES (?,?,?,?,?)";

				$param2 = array($id_media,
							    intval($chap_num),
							    $chap_title,
							    $fan_fiction,
							    0
				);

				myQuery($query2, 'insert', $param2);
			}
			if ($media_type_id == 5)
			{
				global $path;
				global $extensions;

				if ($select_input_file == 1)
				{
					$errors = array();
					$dest = $path.stringHash($_SESSION['id_user']);

					foreach ($files['tmp_name'] as $key => $tmp_name)
					{
						$file_name = $files['name'][$key];
						$file_newname = $filename[$key];
						$file_size = $files['size'][$key];
						$file_tmp = $files['tmp_name'][$key];
						$file_type = $files['type'][$key];
						$file_error = $files['error'][$key];
						$file_ini = pathinfo($file_name);
						$file_ext = strtolower($file_ini['extension']);
						$new_dest = $dest."/".$file_name;

						if (!is_uploaded_file($file_tmp))
							$errors['up'] = "Error while uploading file";

						if ($file_size > 2097152)
							$errors['size'] = "File size must be less than 2 MB";

						if (!in_array($file_ext, $extensions))
							$errors['ext'] = "Your extension's file is not accepted";

						if ($file_error != 0)
							$errors['err'] = "There was a mistake please try again";

						if (file_exists($new_dest))
							$errors['double'] = "You can't upload the same artwork twice";
								
						if (empty($errors))
						{
							if (!is_dir($dest))
								mkdir($dest, 0700);

							move_uploaded_file($file_tmp, $new_dest);

							$query2 = "INSERT INTO `contents`(`medias_id`,
													      	  `chapter_num`,
													      	  `chapter_name`,
													      	  `filename`,
													      	  `size`,
													      	  `path`,
													      	  `hosted`) 
								   	   VALUES (?,?,?,?,?,?,?)";

							$param2 = array($id_media,
										    intval($chap_num),
										    $chap_title,
										    $file_newname,
										    $file_size,
										    $new_dest,
										    1
							);

							myQuery($query2, 'insert', $param2);
						}
						else
							return ($errors);
					}
				}
				elseif ($select_input_file == 2)
				{
					$tab_fileslink = array_combine($file_link, $filename_link);

					foreach ($tab_fileslink as $link => $name)
					{
						$query2 = "INSERT INTO `contents`(`medias_id`,
												      	  `chapter_num`,
												      	  `chapter_name`,
												      	  `filename`,
												      	  `path`,
												      	  `hosted`) 
							   	   VALUES (?,?,?,?,?,?)";

						$param2 = array($id_media,
									    intval($chap_num),
									    $chap_title,
									    $name,
									    $link,
									    0
						);

						myQuery($query2, 'insert', $param2);
					}
				}
			}
			
			$keywords_post = explode(',', $keywords_post);

			foreach ($keywords_post as $keyword_post)
			{
				$query3 = "INSERT INTO `keywords`(`name`) VALUES (?)";
				$param3 = array($keyword_post);
				myQuery($query3, 'insert', $param3);

				$id_keyword = getKeywordId($keyword_post);

				$query4 = "INSERT INTO `medias_has_keywords`(`medias_id`,`keywords_id`) VALUES (?,?)";
				$param4 = array($id_media, $id_keyword);
				myQuery($query4, 'insert', $param4);
			}
		}
	}
		

?>