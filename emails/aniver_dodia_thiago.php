<?php
# formato da imagem a enviar: (9 colunas por 5 linhas no photoshop) -- TAREFA CRON NO SITE VITOR.POA
use PHPMailer \ PHPMailer \ PHPMailer;
include_once("../utilitarios/funcoes.php");
$prg = $_SERVER['SCRIPT_NAME'];
$id = 1; // usuario =A(100,80);
$versao= '202011062100';


$id_pol= 1;
$politico= 'Dep. Dr Thiago';
#$email_pol= 'dr.thiago@al.rs.gov.br';
$email_pol = 'duharte@terra.com.br';
// conectar ao banco do usuário
$_SESSION['servidor'] = "191.252.101.58";
$_SESSION['banco'] = "drthiago_sigre";
$_SESSION['usuario'] = "sigre";
$_SESSION['senha'] = "sigre2018";

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

require_once("../phpmailer/PHPMailer.php");
require_once("../phpmailer/SMTP.php");
require_once('../phpmailer/Exception.php');


$_sql = 'select 
    `cadastro`.`CODIGO` AS `codigo`,
    `cadastro`.`SEXO` AS `sexo`,
    `cadastro`.`NOME` AS `nome`,
    `cadastro`.`EMAIL` AS `email`,
    `cadastro`.`DTNASC` AS `aniver`,
    `cadastro`.`APELIDO` AS `apelido` 
  from 
    `cadastro` 
  where ((MONTH(cadastro.DTNASC)= '.$mes.') AND (DAYOFMONTH(cadastro.DTNASC) = '.$dia.') and (`cadastro`.`RECEBEMAIL` = 1) and (`cadastro`.`EMAIL` > "A") and (`cadastro`.`CONDICAO` = 1))';
$_res = $_con->query($_sql);
$qtd_emails= 0;
$pessoas="";
$emailserrados = '';
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
			<!-- Save for Web Slices (thiago-aniversario.psd) -->
			<table id="Tabela_01" width="580" height="435" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_01.jpg" width="194" height="48" alt=""></td>
					<td background="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_02.jpg" width="194" height="48" alt="">
						<font face="Tahoma, Geneva, sans-serif" size="+2" color="#094582" 
						style="marquee-speed:normal"><strong>'.$primnome.'</strong></font>
					</td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_03.jpg" width="194" height="48" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_04.jpg" width="194" height="49" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_05.jpg" width="194" height="49" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_06.jpg" width="193" height="49" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_07.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_08.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_09.jpg" width="194" height="48" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_10.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_11.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_12.jpg" width="194" height="48" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_13.jpg" width="194" height="49" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_14.jpg" width="194" height="49" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_15.jpg" width="193" height="49" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_16.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_17.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_18.jpg" width="194" height="48" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_19.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_20.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_21.jpg" width="194" height="48" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_22.jpg" width="194" height="49" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_23.jpg" width="194" height="49" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_24.jpg" width="193" height="49" alt=""></td>
				</tr>
				<tr>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_25.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_26.jpg" width="194" height="48" alt=""></td>
					<td>
						<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_27.jpg" width="194" height="48" alt=""></td>
				</tr>
			</table>
			<!-- End Save for Web Slices -->
			<table width="580" border="0" cellpadding="0" cellspacing="0">  <tr>    <td width="100%"><hr />      
				<p><font face="Verdana, Arial" size=1><font color=#808080>
				<b>OBS:</b> Voc&ecirc; est&aacute; recebendo este e-mail porque est&aacute; cadastrado para tal. Caso voc&ecirc; n&atilde;o deseje mais receber nenhum tipo de contato nosso, 
				</font><a title=mailto:'.$email_pol.'?subject=REMOVER href="mailto:'.$email_pol.'?subject=REMOVER">
				<font title=mailto:'.$email_pol.'?subject=REMOVER color=#0000ff>clique aqui</font></a>
				<font color=#808080>, ou  envie um e-mail para <b>
				<a title=mailto:'.$email_pol.' href="mailto:'.$email_pol.'?subject=REMOVER">'.$email_pol.'</a>
				</b> com o assunto REMOVER.<br>  Para garantir o recebimento de nossas mensagens, inclua nosso e-mail em seus contatos.</font>
				</font></p></td>  </tr>
			</table>
			</body>
			</html>';
		$mail = new PHPMailer(true);

		try {
			$mail->Priority = 1;
			# Define os dados do servidor e tipo de conexão
			$mail->setLanguage('br');
			$mail->SMTPDebug = true;
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
		#   ENVIO DA MENSAGEM  #
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
 		} catch (Exception $e) {
			$pessoas .= '<b>'.str_pad($codigo,7).' - '.$nome.' - '.$email.' - ERRO! <br><i>   Erro: ' . $e->getMessage();'</i></b><br>';
			$emailserrados .= '<b>'.str_pad($codigo,7).' - '.$nome.' - ERRO! <br><i>   Erro: ' . $e->getMessage();'</i></b><br>';
		} 
	}
}

$final = '<br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este é um e-mail automático disparado pelo sistema. Favor não respondê-lo, pois esta conta não é monitorada.</font>';

if ($tot_pessoas_select== 0){
	echo 'Nenhuma mensagem enviada em '.date("d/m/Y");
}else{
	if ($tot_pessoas_select== 1){
		if ($tot_pessoas_select == $qtd_emails){
			$mens_qtde = '<pre>Foi enviada 01 mensagem de e-mail de aniversário em '.date("d/m/Y").', conforme abaixo:<br>'.$pessoas.$final.'</pre>';
		}else{
			$mens_qtde = '<pre>Foi feita 01 tentativa de enviar e-mail de aniversário em '.date("d/m/Y").', conforme abaixo:<br>'.$pessoas.$final.'</pre>';
		}
	}else{
		$mens_qtde = '<pre>Foram enviadas '.$qtd_emails.' de '.$tot_pessoas_select.' possíveis mensagens de e-mail de aniversário em '.date("d/m/Y").', conforme abaixo:<br>'.$pessoas.$final.'</pre>';
	}
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: Sistema Sigre<sigre@vitor.poa.br>\r\n";
	$subject = 'E-mails para Aniversariantes '.date("d/m/Y").' - Dr Thiago'; # Assunto da mensagem
	$message = $mens_qtde;
	$to = $email_pol;
	$enviado = mail($to, $subject, $message, $headers);
	if ($enviado) {
		echo "E-mail enviado";
	} else {
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: Sistema Sigre<sigre@vitor.poa.br>\r\n";
		$subject = 'Erro Aniver Dia '.date("d/m/Y").' Info - Dr Thiago'; # Assunto da mensagem
		$message = 'Erro ao enviar e-mail com resumo de aniversariantes para Dr Thiago.<br>'.stripslashes($mens_qtde).'<br>'.$pessoas.'<br>aniver_dodia_thiago.php';//Pretty error messages from PHPMailer
		$to = 'Vitor H M Oliveira<vhmoliveira@protonmail.com>';
		//mail($to, $subject, $message, $headers);
	}

	if ($emailserrados<>'') {
		$mail = new PHPMailer(true); 
		$mail->Priority = 1;
		$mail->setLanguage('br');
		$mail->SMTPDebug = true;
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
		$mail->From = 'sigre@vitor.poa.br';
		$mail->FromName = 'Sistema Sigre'; 
		$mail->IsHTML(true); 
		$mail->AddAddress('vitorhugo@protonmail.com', 'Vitor H M Oliveira'); 
		$mail->Subject = "Emails com ERRO no envio - Dr Thiago "; 
		$mail->setFrom('sigre@vitor.poa.br', 'Sistema Sigre');
		$mail->Body    = stripslashes($emailserrados);
		$mail->AltBody = stripslashes($emailserrados);
		//$mail->Send();			
	}
}
	
?>