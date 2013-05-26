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
	public function getAll(){
			$query="SELECT * FROM ".$this->tableName."";
		$data = myQuery($query,'select',null,'assoc');
		return $data;
	}
	
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
		
		if(empty($this->fields)){
			$this->fieldsTable();
		}
		
		foreach($this->fields as $field){
			if(!empty($this->$field)){
				$part .= "`".$field."`='".myRealString($this->$field)."',";
			}
		}
		$part=substr($part,0,-1);
		$query = 'REPLACE INTO `'.$this->tableName.'`
		SET '.$part.'';
		
		myQuery($query);
		
		if($this->$pk == null){
			$this->set('id',mysqli_insert_id($link));
		}
	}
	
	public function hydrate(){
		// on prepare le debut de la requete
		$query = "SELECT * 
		FROM `".$this->tableName."`";
	
		$pk = $this->primaryKey;
		if (!is_null($this->$pk)){  // si la primarykey a une valeur
			$query .= " WHERE `".$this->primaryKey."` = '".$this->$pk."'";
		}
		elseif(!empty($this->email)){ // sinon on regarde si l'email a une valeur
			$query = "SELECT * 
			FROM `".$this->tableName."`
			WHERE `email`='".myRealString($this->email)."'";
		}
		else{
			trigger_error('Error : You don\'t have set a primary key');
		}
		
		$data = myFetchAssoc($query);
		if(count($data) > 0){ // si il n'y a au moins une ligne de resultat
			foreach ($data[0] as $key => $value){
				$this->$key = $value;
			}
			$this->state_hydrate=true;
		}
		else{
			$this->state_hydrate=false;
		}
	}
}

?>