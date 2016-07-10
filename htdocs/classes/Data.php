<?php
	class Data{
		private $idData;
		private $cpf;
		private $idCategory;
		private $type;
		private $value;
		private $title;
		private $datetime;		
		
		function __construct($idData=0, $cpf='', $idCategory = '', $type='', $value='', $title='',$datetime=''){
			if(($idData)>0){
				
				$Query = mysql_query("Select * from data where idData = '$idData'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->cpf = $Resultado['cpf'];
					$this->idData = $Resultado['idData'];
					$this->idCategory = $Resultado['idCategory'];
					$this->type = $Resultado['type'];
					$this->value = $Resultado['value'];
					$this->title = $Resultado['title'];
					$this->datetime = $Resultado['datetime'];
					
				}
			}else if(($idData)>0){
				$this->cpf = $cpf;	
				$this->idData = $idData;
				$this->idCategory = $idCategory;
				$this->type = $type;
				$this->value = $value;

				$this->title = $title;
				$this->datetime = $datetime;
				;			
				$sql = "Insert into data values('$idData','$cpf','$idCategory','$type','$value', '$title','$datetime')";
				$res = mysql_query($sql) or die(mysql_error());
			}
			
		}
		
		function edit($cpf, $idCategory, $value, $title,$datetime){
			$this->cpf = $cpf;	
			$this->idCategory = $idCategory;
			$this->value = $value;

			$this->title = $title;
			$this->datetime = $datetime;

			$sql = "Update data set cpf = '$cpf', idCategory='$idCategory',value='$value', title='$title' datetime='$datetime' where idData = '$this->idData'";
			$res = mysql_query($sql) or die(mysql_error());
		}

		function delete(){
			$sql = "Delete from data where idData='$this->idData'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		
		function get_cpf(){
			return $this->cpf;
				
		}
		function get_id(){
			return $this->idData;
				
		}

		function get_idCategory(){
			return $this->idCategory;
				
		}

		function get_type(){
			return $this->type;
		}

		function get_value(){
			return $this->value;
		}

		function get_title(){
			return $this->title;
				
		}

		function get_datetime(){
			return $this->datetime;
		}

		function get_category(){
			return new Category($this->idCategory);
		}

		function get_formatted_date(){
			$date = explode(' ',$this->datetime);
			$date = explode('-',$date[0]);
			return $date[2].'/'.$date[1].'/'.$date[0];
		}

		
	}
	
?>