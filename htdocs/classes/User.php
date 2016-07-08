<?php
	class User{
		private $cpf;
		private $name;
		private $email;
		private $password;
		private $birthday;
		private $gender;
		private $zipcode;
		private $idDistrict;
		
		
		function __construct($cpf='', $name='', $email = '', $password='', $birthday='', $gender='',$zipcode='',$idDistrict=0){
			if(strlen($cpf)>0){
				
				$Query = mysql_query("Select * from user where cpf = '$cpf'") or die(mysql_error());
				while($Resultado = mysql_fetch_array($Query)){
					$this->name = $Resultado['name'];
					$this->cpf = $Resultado['cpf'];
					$this->email = $Resultado['email'];
					$this->password = $Resultado['password'];
					$this->birthday = $Resultado['birthday'];
					$this->gender = $Resultado['gender'];
					$this->zipcode = $Resultado['zipcode'];
					$this->idDistrict = $Resultado['idDistrict'];
					
				}
			}else if(strlen($name)>0){
				$this->name = $name;	
				$this->cpf = $cpf;
				$this->email = $email;
				$this->password = $password;
				$this->birthday = $birthday;

				$this->gender = $gender;
				$this->zipcode = $zipcode;
				$this->idDistrict = $idDistrict
				;			
				$sql = "Insert into user values('$cpf','$name','$email','$password','$birthday', '$gender','$zipcode','$idDistrict')";
				$res = mysql_query($sql) or die(mysql_error());
			}
			
		}
		
		function edit($name, $email, $birthday, $gender,$zipcode,$idDistrict){
			$this->name = $name;	
			$this->email = $email;
			$this->birthday = $birthday;

			$this->gender = $gender;
			$this->zipcode = $zipcode;
			$this->idDistrict = $idDistrict

			$sql = "Update user set name = '$name', email='$email',birthday='$birthday', gender='$gender', zipcode='$zipcode', idDistrict='$idDistrict' where cpf = '$this->cpf'";
			$res = mysql_query($sql) or die(mysql_error());
		}

		function delete(){
			$sql = "Delete from user where name='$this->name'";
			$res = mysql_query($sql) or die(mysql_error());		
		}
		
		function get_name(){
			return $this->name;
				
		}
		function get_cpf(){
			return $this->cpf;
				
		}

		function get_email(){
			return $this->email;
				
		}

		function get_password(){
			return $this->password;
		}

		function get_birthday(){
			return $this->birthday;
		}

		function get_gender(){
			return $this->gender;
				
		}

		function get_zipcode(){
			return $this->zipcode;
		}

		function get_idDistrict(){
			return $this->idDistrict;
		}

		function get_district(){
			return new District($this->idDistrict);
		}

		function edit_password($password){
			$sql = "Update User set password = '$password' where cpf = '$this->cpf'";
			$res = mysql_query($sql) or die(mysql_error());	
		}
		
	}
	
?>