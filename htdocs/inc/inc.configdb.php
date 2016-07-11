<?php

require_once('class.DbAdmin.inc.php');

	define('HOST', 'mysql04.site1364927330.hospedagemdesites.ws');
	define('USER', 'site13649273303');
	define('PASS', 'padraods123');
	define('BASE', 'site13649273303');



$db = new DbAdmin('mysql');

$db-> connect(HOST, USER, PASS, BASE);

	# Anti-Injection
	function antiInjection($String)	{
	    $String = get_magic_quotes_gpc() ? stripslashes($String) : $String;
		$String = htmlspecialchars($String, ENT_QUOTES);
	    return $String;
	}
	
	function antiSQLInjection($String) {
	    $String = get_magic_quotes_gpc() ? stripslashes($String) : $String;
	    $String = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($String) : mysql_escape_string($String);
	    return utf8_decode($String);
	}



?>
