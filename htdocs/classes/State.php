<?php
	class State{
		public $idState;
		public $initials;
		public $name;
		
		
		
		function __construct($idState=0,$name='', $initials = ''){
			if($idState>0){
				
				$Query = mysql_query("Select * from state where idState = '$idState'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->idState = $Resultado['idState'];
					$this->initials = $Resultado['initials'];
					$this->name = $Resultado['name'];
					
				}
			}else if(strlen($name)>0){
				$this->idState = $idState;
				$this->initials = $initials;
				$this->name = $name;

				$sql = "Insert into state value('','$name','$initials')";
				$res = mysql_query($sql) or die(mysql_error());

			}
			
		}
		function edit($name,$initials){
			$sql = "Upname state set initials='$initials', name='$name' where idState = '$this->idState'";
			$res = mysql_query($sql) or die(mysql_error());		
		}

		function delete(){
			$sql = "Delete from state where idState='$this->idState'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		function get_id(){
			return $this->idState;
				
		}
		function get_initials(){
			return $this->idState;
				
		}

		function get_name(){
			return $this->name;
				
		}
		
	}
	
?>