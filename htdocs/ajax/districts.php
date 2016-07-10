<?php
	require_once('../inc/functions.php');
	require_once('../inc/inc.configdb.php');
	if(!isset($_REQUEST['id']))
	print_districts($_REQUEST['idCity'],0);
	else print_districts($_REQUEST['idCity'],$_REQUEST['id']);
?>