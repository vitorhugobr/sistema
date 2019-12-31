<?php
# formato da imagem a enviar: (9 colunas por 5 linhas no photoshop)
session_start();
$_SG['servidor'] = "www.vitor.poa.br";
$_SG['banco'] = "vitorpoa_teste";
$_SG['usuario'] = "vitorpoa_user";
$_SG['senha'] = "vhmo@2017";


$_SG['servidor'] = "www.rpujol.com.br";
$_SG['banco'] = "rpujolco_pujol";
$_SG['usuario'] = "rpujolco_pujol";
$_SG['senha'] = "vhm@2019";

$politico = 'Reginaldo Pujol';
$email_pol ='vereadorpujol@gmail.com';

$_con  = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}

mysqli_set_charset($_con,"utf8");
mysqli_query($_con, "SET NAMES 'utf8'");
mysqli_query($_con, 'SET character_set_connection=utf8');
mysqli_query($_con, 'SET character_set_client=utf8');
mysqli_query($_con, 'SET character_set_results=utf8');

$datatoday = getdate();
$dia = $datatoday["mday"];
$mes = $datatoday["mon"];

require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");

# Inicia a classe PHPMailer
$_sql = "SELECT * from controle_envio WHERE id=1 and lote_aberto = 0;";
$_res = $_con->query($_sql);
if($_res->num_rows==0) {
	echo "Lote fechado ou ERRO";
} else {
	$_row = $_res->fetch_assoc();	
	$indice = 1;
	foreach ($_row as $campo => $valor) {
		$_valor    = $valor;
		$_campo    = $campo;
		switch($indice) {
			case 1:
				$id = $_valor;
			case 2:	
				$lote_aberto= $_valor;
			case 3:
				$ultimo_registro = $_valor;
			case 4:
				$subj = $_valor;
			case 5:
				$mensagem = $_valor;
			default:			
		}
		$indice++;
	}
	echo 'Lote aberto: '.$lote_aberto.'<br>';
	echo 'registros ...'.$_res->num_rows.'<br>';

	$_sql = 'SELECT * FROM cadastro_email limit '.$ultimo_registro.', 30';
	// INIBIR LINHA ABAIXO QDO EM PRODUTO
	$_sql = 'SELECT * FROM cadastro_email WHERE codigo=11650';

	$_res = $_con->query($_sql);
	$qtd_emails= 0;
	$pessoas="";
	if($_res->num_rows>0){
		while($_row = $_res->fetch_assoc()) {
			$mail = new PHPMailer();
			# Define os dados do servidor e tipo de conexão
			$mail->IsSMTP(); // Define que a mensagem será SMTP
			$mail->Host = "empregosnainternet.com.br"; # Endereço do servidor SMTP
			$mail->Port = 587; // Porta TCP para a conexão
			$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
			$mail->Username = 'folder'; # Usuário de e-mail
			$mail->Password = 'cfcd378b6'; // # Senha do usuário de e-mail
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->CharSet = "UTF-8";
			$mail->smtpConnect(
				array(
					"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
					"allow_self_signed" => true
					)
				)
			);

			# Define o remetente (você)
			$mail->From = $email_pol; # Seu e-mail
			$mail->FromName = $politico; // Seu nome

			# Define os dados técnicos da Mensagem
			$mail->IsHTML(true); # Define que o e-mail será enviado como HTML

			$qtd_emails= $qtd_emails + 1;
			$codigo = $_row["codigo"];
			$apelido = $_row["apelido"];
			$nome = $_row["nome"];
			$pieces = explode(" ", $nome);
			if ($apelido > "A"){
				$primnome = $apelido;
			}else{
				$primnome =  $pieces[0]; 
			}
			$sexo = $_row["sexo"];
			$email = $_row["email"];
			if ($sexo=="M"){
				$genero="o";
			}else{
				$genero="a";
			}

			$mail->AddAddress($email, $nome); # Os campos podem ser substituidos por variáveis
			$mail->Subject = 'Posse Presidente Câmara Municipal de Porto Alegre'; # Assunto da mensagem

			$mensagem = '<html>
			<head>
			<title>Convite Posse Pujol</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			</head>
			<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
			<!-- Save for Web Slices (convite_pujol.jpg) -->
			<table id="Tabela_01" width="785" height="555" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_01.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_02.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_03.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_04.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_05.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_06.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_07.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_08.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_09.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_10.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_11.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_12.jpg" width="263" height="111" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_13.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_14.jpg" width="263" height="111" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.rpujol.com.br/sigre/emails/images/convite_pujol_15.jpg" width="263" height="111" alt=""></td>
				</tr>
			</table>
			<!-- End Save for Web Slices -->
			</body>
			</html>';	
			$mail->setFrom($email_pol, $politico);

			$mail->Body    = stripslashes($mensagem);
			$mail->AltBody = stripslashes($mensagem);
			#echo stripslashes($mensagem);
			#echo "<br>";

			$enviado = $mail->Send();
			if ($enviado){
				$pessoas .= str_pad($codigo,7)." - ".$nome.' - '.$email.'<br>';
				#echo "E-mail enviado com sucesso para ".$nome."<br>";
				$data = date("Y/m/d H:i:s");
				$seq = 'NULL';	
				// insere na tabela emails enviados
				$strsql5 = "INSERT INTO `emails_enviados` VALUES (";
				$strsql5 .= $seq.",'".$data."',".$codigo.",'".$nome."','".$email."','".$mail->Subject."')";
				$resposta = $_con->query($strsql5);
				echo $strsql5."<br>";
				$enviado=false;
			} else {
				$pessoas .= str_pad($codigo,7)." - ".$nome.' - '.$email.' Não foi possível enviar o e-mail <br>';
				echo "Não foi possível enviar o e-mail final.";
				echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
			}
			
		}
		$ult_enviado = $ultimo_registro + 25;		//ALTERA O ARQUIVO controle_envio
		$strsql6 = 'UPDATE controle_envio SET ultimo_registro = '.$ult_enviado.' where id=1';
		$_res5 = $_con->query($strsql6);
		if (!$_res5){
			$mens_qtde = 'ERRO UPADTE ARQUIVO '. mysql_error($_con).'<br>';  
			echo 'ERRO UPADTE ARQUIVO '. mysql_error($_con).'<br>';  
		}else{
			$mens_qtde='';
		}
	}else{
		#AQUI FINALIZA LOTE
		//echo "Lote ENCERRADO";
		//ALTERA O ARQUIVO controle_envio
		$strsql6 = "UPDATE controle_envio SET lote_aberto = 1 where id=1";
		$_res5 = $_con->query($strsql6);
	}
}
echo "Qtde emails ".$qtd_emails."<br>";

$final = '<br><br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este é um e-mail automático disparado pelo sistema. Favor não respondê-lo, pois esta conta não é monitorada. </font>';

if ($qtd_emails== 0){
	echo 'Nenhuma mensagem enviada em '.date("d/m/Y H:i:s");
}else{
	if ($qtd_emails== 1){
		$mens_qtde = 'Foi enviada 01 mensagem de e-mail '.$mail->Subject.' em '.date("d/m/Y H:i:s").', conforme abaixo:<br>'.$pessoas.$final;
	}else{
		$mens_qtde = 'Foram enviadas '.$qtd_emails.' mensagens de e-mail '.$mail->Subject.' em '.date("d/m/Y H:i:s").', conforme abaixo:<br>'.$pessoas.$final;
	}
	/* headers adicionais */
	# Inicia a classe PHPMailer
	$mail = new PHPMailer();

	# Define os dados do servidor e tipo de conexão
	$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->Host = "empregosnainternet.com.br"; # Endereço do servidor SMTP
	$mail->Port = 587; // Porta TCP para a conexão
	$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
	$mail->Username = 'folder'; # Usuário de e-mail
	$mail->Password = 'cfcd378b6'; // # Senha do usuário de e-mail
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->CharSet = "UTF-8";
	$mail->smtpConnect(
		array(
			"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false,
			"allow_self_signed" => true
			)
		)
	);

	# Define o remetente (você)
	$mail->From = $email_pol; # Seu e-mail
	$mail->FromName = $politico; // Seu nome
	# Define os dados técnicos da Mensagem
	$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
	$mail->AddAddress("vhmoliveira@gmail.com","Vitor H M Oliveira");
	#$mail->AddAddress($email_pol, $politico); # Os campos podem ser substituidos por variáveis
	$mail->Subject = "E-mails enviados ".$politico; # Assunto da mensagem
	$mail->setFrom('sigre@vitor.poa.br', 'Sistema Sigre');
	$mail->Body    = stripslashes($mens_qtde);
	$mail->AltBody = stripslashes($mens_qtde);
	echo $mens_qtde."<br>";

	$enviado = $mail->Send();
	# Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	# Exibe uma mensagem de resultado (opcional)
	if ($enviado) {
		echo "Envio de E-mail executado com sucesso!";
	} else {
		echo "Não foi possível enviar o e-mail final.";
		echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
	}
}
	
?>