<?php
	session_start();
	
	require_once('inc/inc.configdb.php');
	require_once('inc/functions.php');
	require_once('classes/classe.php');

	$action = '';
	$action = $_REQUEST['action'];
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
					$user = new User($user['cpf']);
					$_SESSION['is_admin'] = false;
					$_SESSION['user'] = $user;
					if(empty($_FILES)){
						if($user->verify_data()){
							$dest = 'dashboard.php';
						}else{
							$msg = 'Por favor envie algum dado do software.';
					  		$dest = 'index.html';
						}
						break;
					}
					$_UP['pasta'] = 'files/';
					
					$ext = strtolower(end(explode('.', $_FILES['file']['name'])));
					if (array_search($ext, ['csv']) === false) {
						if($user->verify_data() == true){
							$dest = 'dashboard.php';
						}else{
							$msg = 'Por favor envie algum dado do software.';
					  		$dest = 'index.html';
						}
						break;
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

						        
						    }
						    $dest = 'dashboard.php';
						    fclose($fp);
						} else {
						    $msg = 'Arquivo incorreto.';
							$dest = 'index.html';
							break;
						} 
					} else {
					  $msg = 'Arquivo incorreto.';
					  $dest = 'index.html';
					  break;
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

		case 'logout':
			session_destroy();
			$dest = "index.html";
		break;


		case 'forgot_password':
			$Query = mysql_query("Select * from User where email = '".antiSQLInjection($_REQUEST['email'])."'") or die(mysql_error());
			if(mysql_num_rows($Query)>0){
				$a = mysql_fetch_array($Query);
				$msg = 'Uma recuperação de senha foi solicitada para esse email em nosso site, clique <a href="http://localhost/rec_password.php?email='.$a['email'].'&token='.$a['password'].'" target="_blank">aqui</a> para recuperá-la.';
				die($msg);sendMail($a['ade_email'],'Recuperação de Senha',$msg);

				$msg = "Instruções para a recuperação de senha foram enviadas para seu email.";
				echo '<script>alert("'.$msg.'");
		    	location.href="login.php";</script>';
				die();
			}else{
				$msg = "Nenhum usuário foi encontrado com esse email.";
				echo '<script>alert("'.$msg.'");
		    	location.href="forgot.php";</script>';
				die();
			}
		break;

		case 'recovery_password':
			$Query = mysql_query("Select * from User where email = '".antiSQLInjection($_REQUEST['email'])."' and password ='".antiSQLInjection($_REQUEST['token'])."'") or die(mysql_error());
			if(mysql_num_rows($Query)>0){
				if(antiSQLInjection($_REQUEST['pass']) == antiSQLInjection($_REQUEST['pass1'])){
					if(strlen(antiSQLInjection($_REQUEST['pass']))>4){
						$a = mysql_fetch_array($Query);
						$user = new User($a['cpf']);
						$user->edit_password(sha1(antiSQLInjection($_REQUEST['pass'])));
						$msg = "Senha alterada com sucesso.";
						echo '<script>alert("'.$msg.'");
				    	location.href="index.html";</script>';
				    }else{
				    	$msg = "Senha digitada muito curta.";
						echo '<script>alert("'.$msg.'");
				    	location.href="rec_password.php?email='.antiSQLInjection($_REQUEST['email']).'&token='.antiSQLInjection($_REQUEST['token']).'";</script>';
				    }
				}else{
					$msg = "Senhas não conferem.";
					echo '<script>alert("'.$msg.'");
			    	location.href="rec_password.php?email='.antiSQLInjection($_REQUEST['email']).'&token='.antiSQLInjection($_REQUEST['token']).'";</script>';
				}

			}
		break;
	}
	
	if(!empty($msg)){
		echo '<script> alert("'.$msg.'"); </script>';
	}

	echo '<script> location.href="'.$dest.'"; </script>';
	
	
?>
