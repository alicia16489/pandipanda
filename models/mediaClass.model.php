<?php
	
	class Media{
		public function getMediasBySearch($post){
			print_r($post);
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
			LEFT JOIN medias_has_admin_labels d ON a.id = d.medias_id 
			LEFT JOIN medias_has_keywords e ON a.id = e.medias_id 
			";
			if($post['type'] != 0 || $post['category'] != 0 || !empty($post['search']) || isset($post['labels'])){
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
			if(isset($post['labels'])){
				if($count != 0){
					$query .= " AND ";
				}
				$query .= "(";
				foreach($post['labels'] as $key => $label_id){
					if($key != 0){
						$query .= " OR ";
					}
					$query .= " d.admin_labels_id = :".$label_id;
					$param[":".$label_id] = $label_id;
				}
				$query .= ")";
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
			print_r($query);
			print_r($param);
			$data=myQuery($query,'select',$param,'assoc');
			return $data;
		}
	
	}
		

?>