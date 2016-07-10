<?php
	require_once('classes/classe.php');
	session_start();
	require_once('inc/inc.configdb.php');
	require_once('inc/functions.php');
	

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
					$user1 = new User(0,$user['cpf']);
					$_SESSION['is_admin'] = $user1->isAdmin();

					$_SESSION['user'] = $user1;
					if(empty($_FILES)){
						if($user1->verify_data()){
							$dest = 'dashboard.php';
						}else{
							$msg = 'Por favor envie algum dado do software.';
					  		$dest = 'index.php';
						}
						break;
					}
					$_UP['pasta'] = 'files/';
					
					$ext = strtolower(end(explode('.', $_FILES['file']['name'])));
					if (array_search($ext, ['csv']) === false) {
						if($user1->verify_data()){
							$dest = 'dashboard.php';
						}else{
							$msg = 'Por favor envie algum dado do software.';
					  		$dest = 'index.php';
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
							$dest = 'index.php';
							break;
						} 
					} else {
					  $msg = 'Arquivo incorreto.';
					  $dest = 'index.php';
					  break;
					}


				}else{
					$msg = 'Usuário ou senha incorreto.';
					$dest = 'index.php';
				}
			}else{
				$msg = 'Por favor preencha todos os dados.';
				$dest = 'index.php';
			}
		break;

		case 'logout':
			session_destroy();
			$dest = "index.php";
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
				    	location.href="index.php";</script>';
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

		case 'register':
			$name = antiSQLInjection($_REQUEST['name']);
			$email = antiSQLInjection($_REQUEST['email']);
			$pass = antiSQLInjection($_REQUEST['password']);
			$pass1 = antiSQLInjection($_REQUEST['password1']);
			$state = antiSQLInjection($_REQUEST['state']);
			$city = antiSQLInjection($_REQUEST['city']);
			$district = antiSQLInjection($_REQUEST['district']);
			$gender = antiSQLInjection($_REQUEST['gender']);
			$cep = antiSQLInjection($_REQUEST['cep']);

			$cpf = str_replace('-','', str_replace('.','',antiSQLInjection($_REQUEST['cpf'])));

			if(!empty($name) && !empty($email) && !empty($state) && !empty($city) && strlen($cpf) == 11 && !empty($district) && !empty($gender) && !empty($cep)){
				if(strlen($pass) >= 5){
					if($pass == $pass1){
						if($state > 0 && $city > 0 && $district > 0){
							$Query = mysql_query("Select * from user where email = '$email' or cpf = '$cpf'") or die(mysql_error());
							if(mysql_num_rows($Query)==0){
								$user = new User($cpf, $name, $email, sha1($pass), '', $gender,$cep,$district);
								$_SESSION['is_admin'] = false;
								$_SESSION['user'] = $user;
								$dest = 'dashboard.php';
							}else{
								$msg = "Email ou cpf já cadastrados em nosso sistema.";
								$dest = 'index.php';
							}
							
						}else{
							$msg = "Por favor selecione todos os campos.";
							$dest = 'index.php';
						}
					}else{
						$msg = "Senhas não conferem.";
						$dest = 'index.php';
					}
				}else{
					$msg = "A senha deve ter no minimo 5 digitos.";
					$dest = 'index.php';
				}
			}else{
				$msg = "Por favor selecione todos os campos.";
				$dest = 'index.php';
			}
		break;

		case 'edit_user':
			$name = antiSQLInjection($_REQUEST['name']);
			$state = antiSQLInjection($_REQUEST['state']);
			$city = antiSQLInjection($_REQUEST['city']);
			$district = antiSQLInjection($_REQUEST['district']);
			$gender = antiSQLInjection($_REQUEST['gender']);
			$cep = antiSQLInjection($_REQUEST['cep']);
			if(!empty($name) && !empty($state) && !empty($city) && !empty($district) && !empty($gender) && !empty($cep)){
				if($state > 0 && $city > 0 && $district > 0){
					$_SESSION['user']->edit($name, $gender,$cep,$district	);
					$dest='edit_user.php';

				}else{
					$msg = "Por favor selecione todos os campos.";
					$dest = 'index.php';
				}

			}else{
				$msg = "Por favor selecione todos os campos.";
				$dest = 'index.php';
			}
				

		break;

		case 'change_password':
			$pass = antiSQLInjection($_REQUEST['pass']);
			$pass1 = antiSQLInjection($_REQUEST['pass1']);
			$pass2 = antiSQLInjection($_REQUEST['pass2']);
			if(!empty($pass) && !empty($pass1) && !empty($pass2)){
				if($pass1 == $pass2){
					if(strlen($pass1)>=5){
						if($_SESSION['user']->get_password() == sha1($pass)){
							$_SESSION['user']->edit_password(sha1($pass1));
							$msg = "Senha alterada com sucesso!";
							$dest = 'edit_user.php';
						}else{
							$msg = "Senha incorreta.";
							$dest = 'edit_user.php';
						}
					}else{
						$msg = "A senha deve ter no minimo 5 caracteres.";
						$dest = 'edit_user.php';
					}
				}else{
					$msg = "Senhas não são iguais.";
					$dest = 'edit_user.php';
				}
			}else{
				$msg = "Por favor preencha todos os campos.";
				$dest = 'edit_user.php';
			}
	}
	
	if(!empty($msg)){
		echo '<script> alert("'.$msg.'"); </script>';
	}

	echo '<script> location.href="'.$dest.'"; </script>';
	
	
?>
