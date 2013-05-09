<?php
class Table{
	protected $tableName;
	protected $primaryKey;
	protected $fields = array();
	protected $dataFields = array();
	
	public function __construct($tablename){
		$this->primaryKey='id';
		$this->tableName=$tablename;
	}
	
	// setters & getters
	public function getFields(){
		return $this->fields;
	}
	
	public function setFields($field){
		$this->fields[] = $field;
	}
	
	public function getDataFields(){
		return $this->dataFields;
	}
	
	public function setDataFields($row,$field){
		$this->dataFields[$row[$this->primaryKey]] = $row[$field];
	}
	
	// methodes
	public function dataField($field){
		$query="SELECT ".$this->primaryKey.",".$field." FROM ".$this->tableName."";
		$data = myQuery($query,'select',null,'assoc');
		
		foreach($data as $row){
			$this->setDataFields($row,$field);
		}
	}
	
	public function fieldsTable(){
		$query="SHOW COLUMNS FROM ".$this->tableName."";
		$data = myQuery($query,'select',null,'assoc');
		
		foreach($data as $row){
			$this->setFields($row['Field']);
		}
	}
	
	public function delete(){
		if (empty($this->primaryKey) || empty($this->tableName))
			die('cannot uset class Table without tablename and primary key setted');

		$query = "delete from `".$this->tableName."`".
		"where `".$this->primaryKey."`='".$this->getId()."'";
	
		myQuery($query);
	}
	
	public function Save(){
		global $link;

		$pk = $this->primaryKey;
		$part=null;
		
		echo $this->id_genre;
		
		foreach($this->fields as $field){
			echo $this->$field."<br>";
			$part .= $field."='".$this->$field."',";
		}
		$part=substr($part,0,-1);
		
		myQuery('REPLACE INTO `'.$this->tableName.'`
		SET '.$part.'');
		
		if($this->$pk == null){
			$this->setIdGenre(mysqli_insert_id($link));
		}
	}
	
	public function hydrate(){
		// on verifie que l'attribut
		// prive 'id' contient une valeur
		// positive
		if ($this->id > 0){
			$query = "select * from `genres`
			where `id`='".$this->id_genre."'";
			$data = myFetchAssoc($query);
			if(isset($data['nom']))
				$this->setNom($data['nom']);
		}
	}
}

?>