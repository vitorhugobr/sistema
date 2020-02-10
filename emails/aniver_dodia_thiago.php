<?php
# formato da imagem a enviar: (9 colunas por 5 linhas no photoshop)
session_start();
$_SG['servidor'] = "www.vitor.poa.br";
$_SG['banco'] = "vitorpoa_teste";
$_SG['usuario'] = "vitorpoa_user";
$_SG['senha'] = "vhmo@2017";

include_once("../utilitarios/funcoes.php");
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

$arqconfig = "../".md5("mapa").".txt";
if (!file_exists($arqconfig)) {
	echo 'IMPOSSÍVEL ACESSAR O SISTEMA.<br>Arquivo de configuração excluído ou danificado! ';
	die;
} 	

$linhas = explode("\n", file_get_contents($arqconfig));
$id = 1; // usuario =A(100,80);
$versao= "4.0.3";


$_sql = "SELECT * from config where id = ".$id;
$_res = $_con->query($_sql);
if($_res->num_rows==0) {
	echo "ERRO";
} else {
	$_row = $_res->fetch_assoc();	
	foreach ($_row as $campo => $valor) {
		$_valor    = $valor;
		$_campo    = $campo;
		switch($indice) {
			case 1:
				$id_pol= $_valor;
			case 2:
				$politico= $_valor;
			case 3:	
				$end_pol= $_valor;
			case 4:
				$email_pol= $_valor;
			case 5:
				$cidade_pol= $_valor;
			case 6:
				$estado_pol= $_valor;
			case 7:
				$cep_pol= $_valor;
			case 8:
				$url_pol= $_valor;
			case 9:
				$endfoto= $_valor;
			case 10:
				$ativo= $_valor;
			case 11:
				$host_pol= $_valor;
			case 12:
				$email_retorno = $_valor;
			case 18:
				$email2 = $_valor;
				break;
			case 19:
				$nome2 = $_valor;
				break;
			case 20:
				$email3 = $_valor;
				break;
			case 21:
				$nome3 = $_valor;
				break;
			case 22:
				$email4 = $_valor;
				break;
			case 23:
				$nome4 = $_valor;
			default:			
		}
		$indice++;
	}
}

// conectar ao banco do usuário
$_SG['servidor'] = "191.252.101.58";
$_SG['banco'] = "drthiago_sigre";
$_SG['usuario'] = "sigre";
$_SG['senha'] = "sigre2018";

$_con  = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	

$datatoday = getdate();
$dia = $datatoday["mday"];
$mes = $datatoday["mon"];

require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");

$_sql = 'SELECT * from emails_aniver where MONTH(aniver)= '.$mes.' AND DAYOFMONTH(aniver) = '.$dia;
#$_sql = 'SELECT * FROM emails_aniver WHERE codigo=41293';
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
		# Define os destinatário(s)
		$mail->AddAddress($email, $nome); # Os campos podem ser substituidos por variáveis
		#$mail->addBCC("vhmoliveira@gmail.com","Vitor H M Oliveira");
		/* assunto */
		# Define a mensagem (Texto e Assunto)
		$mail->Subject = "Parabéns ".$primnome; # Assunto da mensagem
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
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_03.jpg" width="193" height="48" alt=""></td>
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
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_09.jpg" width="193" height="48" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_10.jpg" width="194" height="48" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_11.jpg" width="194" height="48" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_12.jpg" width="193" height="48" alt=""></td>
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
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_18.jpg" width="193" height="48" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_19.jpg" width="194" height="48" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_20.jpg" width="194" height="48" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_21.jpg" width="193" height="48" alt=""></td>
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
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/imagens/1/images/aniversario_27.jpg" width="193" height="48" alt=""></td>
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
		$mail->setFrom($email_pol, $politico);
		$mail->Body    = stripslashes($mensagem);
		$mail->AltBody = stripslashes($mensagem);
		#echo stripslashes($mensagem);
		#echo "<br>";
		$enviado = $mail->Send();
		$pessoas .= str_pad($codigo,7)." - ".$nome.' - '.$email.'<br>';
		if ($enviado){
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
		} else {
			echo "Não foi possível enviar o e-mail final.";
			echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
		}
	}
}

$final = '<br><br><font color="#FF0004" style="font-family: Verdana; font-style: italic; font-size: 9px;">Este é um e-mail automático disparado pelo sistema. Favor não respondê-lo, pois esta conta não é monitorada. </font>';

if ($qtd_emails== 0){
	echo 'Nenhuma mensagem enviada em '.date("d/m/Y");
}else{
	if ($qtd_emails== 1){
		$mens_qtde = 'Foi enviada 01 mensagem de e-mail de aniversário em '.date("d/m/Y").', conforme abaixo:<br>'.$pessoas.$final;
	}else{
		$mens_qtde = 'Foram enviadas '.$qtd_emails.' mensagens de e-mail de aniversário em '.date("d/m/Y").', conforme abaixo:<br>'.$pessoas.$final;
	}
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
	$mail->addAddress("vhmoliveira@gmail.com","Vitor H M Oliveira");
	$mail->AddAddress('duharte@terra.com.br', 'Dr Thiago Duarte'); # Os campos podem ser substituidos por variáveis
	$mail->Subject = "Resumo e-mails enviado - Dr Thiago"; # Assunto da mensagem
	$mail->setFrom('sigre@vitor.poa.br', 'Sistema Sigre');
	$mail->Body    = stripslashes($mens_qtde);
	$mail->AltBody = stripslashes($mens_qtde);
	if (!empty($email2)){
		$mail->AddAddress($email2, $nome2); # Os campos podem ser substituidos por variáveis
	}
	#echo $mens_qtde."<br>";
	$enviado = $mail->Send();
	# Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	# Exibe uma mensagem de resultado (opcional)
	if ($enviado) {
		echo "E-mail enviado com sucesso!";
	} else {
		echo "Não foi possível enviar o e-mail final.";
		echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
	}
}
	
?>