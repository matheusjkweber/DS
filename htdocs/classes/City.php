<?php
	class City{
		public $idCity;
		public $idState;
		public $name;
		
		
		
		function __construct($idCity=0,$idState=0, $name = ''){
			if($idCity>0){
				
				$Query = mysql_query("Select * from city where idCity = '$idCity'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->idCity = $Resultado['idCity'];
					$this->idState = $Resultado['idState'];
					$this->name = $Resultado['name'];
					
				}
			}else if(($idState)>0){
				$this->idState = $idState;
				$this->idCity = mysql_insert_id();
				$this->name = $name;

				$sql = "Insert into city value('','$idState','$name')";
				$res = mysql_query($sql) or die(mysql_error());

			}
			
		}
		function edit($idState,$name){
			$sql = "Upname city set idState='$idState', name='$name' where idCity = '$this->idCity'";
			$res = mysql_query($sql) or die(mysql_error());		
		}

		function delete(){
			$sql = "Delete from city where idCity='$this->idCity'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		function get_idCity(){
			return $this->idCity;
				
		}
		function get_idState(){
			return $this->idState;
				
		}

		function get_state(){
			return new State($this->idState);
		}

		function get_name(){
			return $this->name;
				
		}
		
	}
	
?>