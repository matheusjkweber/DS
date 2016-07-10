<?php
	require_once('../inc/funcoes.php');
	require_once('../inc/inc.configdb.php');
	if(!isset($_REQUEST['id']))
	print_states(0);
	else print_states($_REQUEST['idState']);
?>