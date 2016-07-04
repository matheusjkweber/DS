<?php
	class Operation{
		public $id;
		public $value;
		public $date;
		
		
		
		function __construct($id=0,$value='', $date = ''){
			if($id>0){
				
				$Query = mysql_query("Select * from Operation where id = '$id'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->id = $Resultado['id'];
					$this->value = $Resultado['id'];
					$this->date = $Resultado['date'];
					
				}
			}else if(($value)>0){
				$this->value = $value;				
				$sql = "Insert into Operation values('','$value',NOW())";
				$res = mysql_query($sql) or die(mysql_error());
				$this->id = mysql_insert_id();	
			}
			
		}
		function edit($value){
			$sql = "Update Operation set value='$value' where id = '$this->id'";
			$res = mysql_query($sql) or die(mysql_error());		
		}

		function delete(){
			$sql = "Delete from Operation where id='$this->id'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		function get_id(){
			return $this->id;
				
		}
		function get_value(){
			return $this->value;
				
		}

		function get_date(){
			return $this->date;
				
		}
		
	}
	
?>