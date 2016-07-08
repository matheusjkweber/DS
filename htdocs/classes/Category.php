<?php
	class Category{
		public $idCategory;
		public $name;
		
		
		
		function __construct($idCategory=0,$type='', $name = ''){
			if($idCategory>0){
				
				$Query = mysql_query("Select * from category where idCategory = '$idCategory'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->idCategory = $Resultado['idCategory'];
					$this->name = $Resultado['name'];
					
				}
			}else if(strlen($name)>0){
				$this->idCategory = mysql_insert_id();
				$this->name = $name;

				$sql = "Insert into Category values('','$type','$name')";
				$res = mysql_query($sql) or die(mysql_error());

			}
			
		}
		function edit($name){
			$sql = "Update category set  name='$name' where idCategory = '$this->idCategory'";
			$res = mysql_query($sql) or die(mysql_error());		
		}

		function delete(){
			$sql = "Delete from category where idCategory='$this->idCategory'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		function get_idCategory(){
			return $this->idCategory;
				
		}
		

		function get_name(){
			return $this->name;
				
		}
		
	}
	
?>