<?php
	class Access{
		private $idAccess;
		private $cpf;
		private $datetime;
		private $type;
		private $ip;
		
		
		function __construct($id=0,$cpf='', $datetime = '', $type='', $ip=''){
			if($id>0){
				
				$Query = mysql_query("Select * from access where idAccess = '$id'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->idAccess = $Resultado['id'];
					$this->cpf = $Resultado['cpf'];
					$this->datetime = $Resultado['datetime'];
					$this->type = $Resultado['type'];
					$this->ip = $Resultado['ip'];
					
				}
			}else if(($id)>0){
				$this->idAccess = $id;	
				$this->cpf = $cpf;
				$this->datetime = $datetime;
				$this->type = $type;
				$this->ip = $ip;			
				$sql = "Insert into access values('','$cpf',NOW(),'$type','$ip')";
				$res = mysql_query($sql) or die(mysql_error());
				$this->id = mysql_insert_id();	
			}
			
		}
		

		function delete(){
			$sql = "Delete from access where idAccess='$this->idAccess'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		
		function get_id(){
			return $this->idAccess;
				
		}
		function get_cpf(){
			return $this->cpf;
				
		}

		function get_date(){
			return $this->datetime;
				
		}

		function get_type(){
			return $this->type;
		}

		function get_ip(){
			return $this->ip;
		}
		
	}
	
?>