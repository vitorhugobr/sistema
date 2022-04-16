<?php
# formato da imagem a enviar: (9 colunas por 5 linhas no photoshop) CRON NO SITE PUJOL

include_once("../utilitarios/funcoes.php");

$id = 1; // usuario =A(100,80);
$versao= "4.0.3";


$id_pol= 1;
$politico= 'Emerson Correa';
$email_pol= 'veremerson@gmail.com';

// conectar ao banco do usuário
$_SESSION['servidor'] = "www.serverwebdb.com.br";
$_SESSION['banco'] = "chaplinb_chaplin";
$_SESSION['usuario'] = "chaplinb_chaplin";
$_SESSION['senha'] = "HpcOKYN7b2E-";

$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	
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

//$_sql = 'select * from aniversarios_email  where ((MES= '.$mes.') AND (DIA = '.$dia.') and (`RECEBEMAIL` = 1) and (`EMAIL` > "A") and (`CONDICAO` = 1))';
$_sql = 'select * from aniversarios_email where ((`CODIGO` = 11650))';

$_res = $_con->query($_sql);
$qtd_emails= 0;
$pessoas="";
$tot_pessoas_select = 0;
if($_res->num_rows>0){
	$tot_pessoas_select = $_res->num_rows;
	while($_row = $_res->fetch_assoc()) {
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
		$mensagem = '<html>
				<head>
				<title>Parabéns</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				</head>
				<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
				<!-- Save for Web Slices (niver1.psd) -->
				<table id="Tabela_01" width="750" height="540" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" colspan="6" background="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_01.jpg" width="750" height="90" alt="">
										<font face="Tahoma, Geneva, sans-serif" size="+7" color="#07FA17" 
										style="marquee-speed:normal"><strong>'.$primnome.'</strong></font>
						<td >
					</tr>
					<tr>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_02.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_03.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_04.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_05.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_06.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_07.gif" width="125" height="90" alt=""></td>
					</tr>
					<tr>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_08.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_09.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_10.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_11.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_12.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_13.gif" width="125" height="90" alt=""></td>
					</tr>
					<tr>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_14.gif" width="125" height="89" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_15.gif" width="125" height="89" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_16.gif" width="125" height="89" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_17.gif" width="125" height="89" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_18.gif" width="125" height="89" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_19.gif" width="125" height="89" alt=""></td>
					</tr>
					<tr>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_20.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_21.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_22.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_23.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_24.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_25.gif" width="125" height="90" alt=""></td>
					</tr>
					<tr>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_26.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_27.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_28.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_29.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_30.gif" width="125" height="90" alt=""></td>
						<td>
							<img src="https://www.chaplinbebidas.com.br/sigre/emails/imagens/2/niver1_31.gif" width="125" height="90" alt=""></td>
					</tr>
				</table>
				<!-- End Save for Web Slices -->
				<table width="100%" border="0" align="center">  <tr>    <td width="100%"><hr />      
					<p><font face="Verdana, Arial" size=1><font color=#808080>
					<b>OBS:</b> Voc&ecirc; est&aacute; recebendo este e-mail porque est&aacute; cadastrado para tal. Caso voc&ecirc; n&atilde;o deseje mais receber nenhum tipo de contato nosso, 
					</font><a title=mailto:'.$email_pol.'?subject=REMOVER href="mailto:'.$email_pol.'?subject=REMOVER">
					<font title=mailto:'.$email_pol.'?subject=REMOVER color=#0000ff>clique aqui</font></a>
					<font color=#808080>, ou  envie um e-mail para <b>
					<a title=mailto:'.$email_pol.' href="mailto:'.$email_pol.'?subject=REMOVER">'.$email_pol.'</a>
					</b> com o assunto REMOVER.<br>  Para garantir o recebimento de nossas mensagens, inclua nosso e-mail em seus contatos.</font>
					</font></p></td></tr>
				</table>

				</body>
				</html>';			
		$mail = new PHPMailer(true);
		try {
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
			# Define os destinatário(s)
			$mail->AddAddress($email, $nome); # Os campos podem ser substituidos por variáveis
			#$mail->addBCC("vhmoliveira@gmail.com","Vitor H M Oliveira");
			/* assunto */
			# Define a mensagem (Texto e Assunto)
			$mail->Subject = "Parabéns ".$primnome; # Assunto da mensagem
			$mail->setFrom($email_pol, $politico);
			$mail->Body    = stripslashes($mensagem);
			$mail->AltBody = stripslashes($mensagem);
			#echo stripslashes($mensagem);
			#echo "<br>";
			$mail->Send();
			$qtd_emails= $qtd_emails + 1;
		    $pessoas .= str_pad($codigo,7)." - ".$nome.' - '.$email.' - SUCESSO!<br>';
			#echo "E-mail enviado com sucesso para ".$nome."<br>";
			$data = date("d/m/Y");
			$assunto = "ENVIADO E-MAIL DE ANIVERSARIO PELO SISTEMA";
			$visita = 'NULL';	
			// VISITA
			$theValue = (!get_magic_quotes_gpc()) ? addslashes($visita) : $visita;
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			$fieldList["`Visita`"] = $theValue;
			// CODIGO
			$theValue = (!get_magic_quotes_gpc()) ? addslashes($codigo) : $codigo;
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			$fieldList["`Visitante`"] = $theValue;
			// DATA
			$theValue = (!get_magic_quotes_gpc()) ? addslashes($data) : $data;
			$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
			$fieldList["`DataDaVisita`"] = $theValue;
			// ASSUNTO
			$theValue = (!get_magic_quotes_gpc()) ? addslashes($assunto) : $assunto;
			$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
			$fieldList["`Assunto`"] = $theValue;
			// insere no banco VISITAS
			$strsql5 = "INSERT INTO `visitas` (";
			$strsql5 .= implode(",", array_keys($fieldList));
			$strsql5 .= ") VALUES (";
			$strsql5 .= implode(",", array_values($fieldList));
			$strsql5 .= ")";
			$resposta = $_con->query($strsql5);
			$enviado=false;
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  $pessoas .= '<b>'.str_pad($codigo,7).' - '.$nome.' - '.$email.' - ERRO! <br><i>   Informações do erro: ' . $e->errorMessage();'</i></b><br>';
		} catch (Exception $e) {
		  echo $e->getMessage(); //Boring error messages from anything else!
		  $pessoas .= '<b>'.str_pad($codigo,7).' - '.$nome.' - '.$email.' - ERRO! <br><i>   Informações do erro: ' . $e->getMessage();'</i></b><br>';
		}	}
}

$final = '<br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este é um e-mail automático disparado pelo sistema. Favor não respondê-lo, pois esta conta não é monitorada. </font>';

if ($tot_pessoas_select== 0){
	echo 'Nenhuma mensagem enviada em '.date("d/m/Y");
}else{
	$mens_qtde = '<pre>Foram enviadas '.$qtd_emails.' de '.$tot_pessoas_select.' possíveis mensagens de e-mail de aniversário em '.date("d/m/Y").', conforme abaixo:<br>'.$pessoas.$final.'</pre>';
	
	# Inicia a classe PHPMailer
	$mail = new PHPMailer(true);
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
	$mail->From = 'sigre@vitor.poa.br'; # Seu e-mail
	$mail->FromName = 'Sistema Sigre'; // Seu nome
	# Define os dados técnicos da Mensagem
	$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
	//$mail->addBCC("vhmoliveira@yahoo.com.br","Vitor H M Oliveira");
	$mail->AddAddress("vhmoliveira@gmail.com","Vitor H M Oliveira");
	//$mail->AddAddress($email_pol, $politico); # Os campos  podem ser substituidos por variáveis
	$mail->Subject = "E-mails para Aniversariantes - Emerson"; # Assunto da mensagem
	$mail->setFrom('sigre@vitor.poa.br', 'Sistema Sigre');
	$mail->Body    = stripslashes($mens_qtde);
	$mail->AltBody = stripslashes($mens_qtde);
	echo $mens_qtde."<br>";
	try {
		$mail->Send();
		echo "Mensagem Enviada OK\n";
	} catch (phpmailerException $e) {
	  echo "deu mer.. ".$e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  echo "deu mer.. ".$e->getMessage(); //Boring error messages from anything else!
	}
}
	
?>