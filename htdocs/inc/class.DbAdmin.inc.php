<?php

class DbAdmin{
	
	//propriedades (variaveis)
	
	private $tipo; //ex.: mysql, pgsql, mssql, oracle,etc...
	private $conn; // identificador da conexao com o sgbd
	
	//metodo construtor
	//o nome do metodo construtor pode ser o proprio nome da classe
	//poderia fazer assim:
	//public function DbAdmin($tipo){
	
	
	public function __construct($tipo){
		$this -> tipo = $tipo;	
	
	}
	
	//método que connecta que connecta com o banco de dados
	
	public function connect($host,$user,$pass,$base){
		
		switch($this->tipo){
			
			case 'mysql':
			$this-> conexao = mysql_connect($host, $user, $pass, $base);
			mysql_select_db($base);
			break;
		
			case 'mysql':
			$this-> conexao = mssql_connect($host, $user, $pass, $base);
			mssql_select_db($base);
			break;
	        
			case 'pgsql':
			$string = "host = $host port= 5432 dbname = $base user = &user password = $pass";
			$this-> conexao = pg_connect($string);
			//mssql_select_db($base); | o dbnam já fez isso.
			
			}
		}
	
	//METODOD QUE EXECUTA UMA INSTRUÇÃO SQL	
	public function query($sql){
		
		switch($this->tipo)
		{
			case 'mysql':
			$rs = mysql_query($sql, $this->conexao) or die (mysql_error());
			break;
			
			case 'mssql':
			$rs = mssql_query($sql, $this->conexao) or die (mssql_get_last_message());
			break;
			
			case 'pgsql':
			$rs = pg_query($sql, $this->conexao) or die (pg_last_error());
			break;
		}
		
		return $rs;
	}
	//METODO QUE RETORNA O NUMERO DE LINHAS DO RECORDSET
	public function rows($rs){
		switch($this->tipo){
		
			case 'mysql':
			$num = mysql_num_rows($rs);
			break;
			
			case 'mssql':
			$num = mssql_num_rows($rs);
			break;
			
			case 'mssql':
			$num = pg_num_rows($rs);
			break;
		}
		
		return $num;
	}

	//METODO QUE RETORNA UM VALOR ESPECIFICO DO RECORDSET
	
	public function result($rs, $lin, $col){
		switch($this-> tipo){
		
		case 'mysql' : 
		$valor = mysql_result($rs, $lin, $col);
		break;
		
		case 'mssql' : 
		$valor = mssql_result($rs, $lin, $col);
		break;
		
		case 'pgsql' : 
		$valor = pg_fetch_result($rs, $lin, $col);
		break;
		}
		
		return $valor;
	
	}//fimm da function
	}


?>