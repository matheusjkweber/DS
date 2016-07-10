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
		private $balance;
		
	function __construct($create=1,$cpf='', $name='', $email = '', $password='', $birthday='', $gender='',$zipcode='',$idDistrict=0){
		if($create == 0){
			
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
			$this->balance = 0;
			$Query = mysql_query("Select * from data where cpf = $this->cpf") or die(mysql_error());
			while($a = mysql_fetch_array($Query)){
				if($a['type']==0){
					$this->balance = $this->balance + $a['value'];
				}else{
					$this->balance = $this->balance - $a['value'];
				}
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
		
		function edit($name, $gender,$zipcode,$idDistrict){
			$this->name = $name;	

			$this->gender = $gender;
			$this->zipcode = $zipcode;
			$this->idDistrict = $idDistrict;

			$sql = "Update user set name = '$name', gender='$gender', zipcode='$zipcode', idDistrict='$idDistrict' where cpf = '$this->cpf'";
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

		function get_idCity(){
			$district = new District($this->idDistrict);
			return $district->get_idCity();
		}

		function get_idState(){
			$district = new District($this->idDistrict);
			$city = $district->get_city();
			return $city->get_idState();
		}

		function edit_password($password){
			$sql = "Update User set password = '$password' where cpf = '$this->cpf'";
			$res = mysql_query($sql) or die(mysql_error());	
		}

		function verify_data(){
			$sql = "Select * from data where cpf = '$this->cpf'";
			$res = mysql_query($sql) or die(mysql_error());	
			if(mysql_num_rows($res)>0){
				return true;
			}else{
				return false;
			}
		}

		function print_operations($type=2,$from='',$to=''){
			$where = '';
			if($type < 2){
				$where .= ' and type= '.$type;
			}
			if(strlen($from)>0 && strlen($to)>0){
				$where .= ' and datetime >= "'.$from.'" and datetime <= "'.$to.'"';
			}
			$Query = mysql_query("Select * from data where cpf = $this->cpf $where order by datetime asc") or die(mysql_error());
			while($a = mysql_fetch_array($Query)){
				$data = new Data($a['idData']);
				echo '<tr>
                		<td>'.utf8_encode($data->get_title()).'</td>
                		<td>'.utf8_encode($data->get_category()->get_name()).'</td>
                		<td>'.number_format($data->get_value(),2,',','.').'</td>
                		<td>'.$data->get_formatted_date().'</td>
                	</tr>';
              }
		}

		function get_balance(){
			return $this->balance;
		}

		function isAdmin(){
			$Query = mysql_query("Select * from admin where cpf = $this->cpf") or die(mysql_error());
			if(mysql_num_rows($Query)>0){
				return true;
			}else return false;
		}
		
	}
	
?>