<?php
	require_once('../inc/functions.php');
	require_once('../inc/inc.configdb.php');
	if(!isset($_REQUEST['id']))
	print_cities($_REQUEST['idState'],0);
	else print_cities($_REQUEST['idState'],$_REQUEST['id']);
?>