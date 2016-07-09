<?php
	class Admin extends User{
		private $cpf;

		function __construct($cpf='', $name='', $email = '', $password='', $birthday='', $gender='',$zipcode='',$idDistrict=0){
			if(strlen($cpf)>0){
				parent::__construct($cpf,$name,$email,$password,$birthday,$gender,$zipcode,$idDistrict);
			}
			
		}
	}
	
?>