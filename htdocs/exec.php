<?php
	session_start();
	
	require_once('inc/inc.configdb.php');
	require_once('inc/functions.php');

	$action = '';
	$action = $_POST['action'];
	$msg = '';
	$dest = '';
	
	switch($action){
		case 'login':

			if(!empty($_POST['email']) && !empty($_POST['senha'])){
				$email = antiSQLInjection($_POST['email']);
				$password = (antiSQLInjection($_POST['senha']));
				
				$Query = mysql_query("Select * from user where email = '$email' and password = '".sha1($password)."'") or die(mysql_error());
				if(mysql_num_rows($Query)>0){
					$user = mysql_fetch_array($Query);
					$_UP['pasta'] = 'files/';
					
					$ext = strtolower(end(explode('.', $_FILES['file']['name'])));
					if (array_search($ext, ['csv']) === false) {
					  // erro tipo arquivo
					  exit;
					}
					
					$final_name = md5(time()).'.csv';
					  
					// Depois verifica se é possível mover o arquivo para a pasta escolhida
					if (move_uploaded_file($_FILES['file']['tmp_name'], 'csvs/'. $final_name)) {
					  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
					 //Trata sucesso
						$fp = fopen('csvs/'.$final_name, 'r');
						$line = fgets($fp);
						if ($fp) {
						    while (($line = fgets($fp)) !== false) {
						        // process the line read.
						        $line = explode(',', $line);
						        $type = 1;
						       
						        if($line[1] == 'Revenue'){
						        	$type = 0;
						        }
						        
						        $date = $line[5];
						        $date = explode(' ',$date);
						        $day = $date[2];
						        $month = month_to_number($date[1]);
						        $year = substr($date[5],0,-1);
						        $time = $date[3];
						        
						        $sql = "Insert into data values('','".$user['cpf']."','".$line[3]."','$type','".$line[2]."','".utf8_decode($line[4])."','$year-$month-$day $time')";
						        $db->query($sql);

						        $dest = 'dashboard.php';
						        
						    }

						    fclose($fp);
						} else {
						    // error opening the file.
						} 
					} else {
					  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
					 // Trata algum erro
						die('lalala1');
					}


				}else{
					$msg = 'Usuário ou senha incorreto.';
					$dest = 'index.html';
				}
			}else{
				$msg = 'Por favor preencha todos os dados.';
				$dest = 'index.html';
			}
		break;
	}
	
	if(!empty($msg)){
		echo '<script> alert("'.$msg.'"); </script>';
	}

	echo '<script> location.href="'.$dest.'"; </script>';
	
	
?>
