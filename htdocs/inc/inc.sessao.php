<?PHP

	//Sessao
		session_start();
		if (!isset($_SESSION['user'])) 
		{
			echo '<script>alert("Sua sessão expirou, logue-se novamente para acessar seus dados."); location.href="index.html"; </script>';
			exit;
		}
	//Final da sessao

?>