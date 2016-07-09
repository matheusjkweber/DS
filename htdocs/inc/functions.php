<?php
	function month_to_number($month){
		switch($month){
			case 'Jan':
				return 1;
			case 'Fev':
				return 2;
			case 'Mar':
				return 3;
			case 'Apr':
				return 4;
			case 'May':
				return 5;
			case 'Jun':
				return 6;
			case 'Jul':
				return 7;
			case 'Agu':
				return 8;
			case 'Sep':
				return 9;
			case 'Oct':
				return 10;
			case 'Nov':
				return 11;
			case 'Dec':
				return 12;
		}
	}

	function sendMail($destinatario,$assunto,$msg){
	
		$corpo = '
	 			<style type="text/css">
			
				body{
					margin:0px;
					padding:0px;
					color:#333;
					letter-spacing:0.1em;
					line-height:120%;
					font-family:Arial, Helvetica, sans-serif;
					font-size:12px;
				}
	
				h1{
					color:#215D7E;
	
				}
	
				p{
					margin:0px;
					padding:0px;
					margin-bottom:5px;
				}
				</style>
				<html>
				<head>
   	
				</head>
				<body>
	
				'.$msg.'<br><br>
				*Esta mensagem foi enviada pelo sistema do site Mauricio Vaz. 
	
				<br><br>
				'.$assinatura.'
	
	
	
	
				</body>
				</html>
		   ';
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html;
					 charset=utf-8 \r\n";
		//endereÃ§o do remitente
		//TROCAR EMAIL AQUI.
		$headers .= "From: Sistema \r\n";
		//TROCAR EMAIL AQUI.
		//endereÃ§o de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: contato@sistema.com.br\r\n";
	
		//endereÃ§os que receberÃ£o uma copia $headers .= "Cc: manel@desarrolloweb.com\r\n";
		//endereÃ§os que receberÃ£o uma copia oculta
	
		mail($destinatario,$assunto,$corpo,$headers);
	
	}
	