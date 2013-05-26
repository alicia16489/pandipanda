<?php
	
	class Media{
		public function getMediasBySearch($post){
			$keywords=filtre($post['search'],' ');
			$id_keywords=array();
			$param=array();
			
			
			if(!empty($post['search'])){ 
				// get id from user keywords
				$query="SELECT name,id FROM keywords a WHERE ";
				foreach($keywords as $key => $keyword){
					if($key != 0){
						$query .= " OR ";
					}
					$query .= "a.name = :".$keyword."";
					$param[":".$keyword] = $keyword;
				}
				$data=myQuery($query,'select',$param,'assoc');
			}
			
			// get medias from id keywords and filter
			$count=0;
			$param=array();
			$query="SELECT a.id, COUNT(a.id) 'nb_keywords', title, resum, active, c.name 'category', b.name 'type'
			FROM  medias a 
			LEFT JOIN media_types b ON a.media_types_id = b.id 
			LEFT JOIN category c ON a.id_category = c.id 
			";
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
	
	}
		

?>