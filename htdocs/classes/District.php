<?php
	class District{
		public $idDistrict;
		public $idCity;
		public $name;
		
		
		
		function __construct($idDistrict=0,$idCity=0, $name = ''){
			if($idDistrict>0){
				
				$Query = mysql_query("Select * from district where idDistrict = '$idDistrict'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->idDistrict = $Resultado['idDistrict'];
					$this->idCity = $Resultado['idCity'];
					$this->name = $Resultado['name'];
					
				}
			}else if(($idCity)>0){
				$this->idCity = $idCity;
				$this->idDistrict = mysql_insert_id();
				$this->name = $name;

				$sql = "Insert into district value('','$idCity','$name')";
				$res = mysql_query($sql) or die(mysql_error());

			}
			
		}
		function edit($idCity,$name){
			$sql = "Update district set idCity='$idCity', name='$name' where idDistrict = '$this->idDistrict'";
			$res = mysql_query($sql) or die(mysql_error());		
		}

		function delete(){
			$sql = "Delete from district where idDistrict='$this->idDistrict'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		function get_idDistrict(){
			return $this->idDistrict;
				
		}
		function get_idCity(){
			return $this->idCity;
				
		}

		function get_city(){
			return new City($this->idCity);
		}

		function get_name(){
			return $this->name;
				
		}
		
	}
	
?>