<?php
# formato da imagem a enviar: (9 colunas por 5 linhas no photoshop)
session_start();

$_SESSION['servidor'] = "191.252.101.58";
$_SESSION['banco'] = "drthiago_sigre";
$_SESSION['usuario'] = "sigre";
$_SESSION['senha'] = "sigre2018";

$politico = 'Deputado Dr Thiago';
$email_pol ='duharte@terra.com.br';

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

	//$_sql = 'SELECT * FROM cadastro_email limit '.$ultimo_registro.', 30';
	// INIBIR LINHA ABAIXO QDO EM PRODUÇÃO
	$_sql = 'SELECT * FROM cadastro_email WHERE codigo=41293';

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
			$mail->Subject = 'Fluxo de Atendimento'; # Assunto da mensagem

			$mensagem = '<html>
<head>
<title>Covid19 - Dr Thiago</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (covid19_thiago.png) -->
<table id="Tabela_01" width="904" height="2544" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_01.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_02.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_03.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_04.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_05.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_06.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_07.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_08.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_09.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_10.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_11.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_12.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_13.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_14.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_15.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_16.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_17.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_18.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_19.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_20.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_21.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_22.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_23.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_24.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_25.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_26.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_27.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_28.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_29.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_30.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_31.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_32.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_33.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_34.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_35.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_36.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_37.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_38.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_39.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_40.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_41.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_42.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_43.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_44.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_45.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_46.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_47.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_48.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_49.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_50.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_51.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_52.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_53.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_54.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_55.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_56.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_57.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_58.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_59.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_60.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_61.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_62.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_63.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_64.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_65.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_66.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_67.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_68.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_69.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_70.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_71.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_72.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_73.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_74.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_75.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_76.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_77.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_78.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_79.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_80.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_81.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_82.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_83.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_84.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_85.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_86.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_87.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_88.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_89.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_90.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_91.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_92.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_93.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_94.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_95.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_96.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_97.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_98.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_99.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_100.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_101.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_102.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_103.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_104.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_105.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_106.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_107.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_108.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_109.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_110.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_111.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_112.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_113.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_114.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_115.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_116.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_117.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_118.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_119.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_120.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_121.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_122.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_123.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_124.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_125.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_126.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_127.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_128.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_129.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_130.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_131.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_132.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_133.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_134.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_135.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_136.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_137.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_138.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_139.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_140.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_141.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_142.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_143.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_144.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_145.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_146.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_147.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_148.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_149.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_150.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_151.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_152.jpg" width="113" height="128" alt=""></td>
	</tr>
	<tr>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_153.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_154.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_155.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_156.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_157.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_158.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_159.jpg" width="113" height="128" alt=""></td>
		<td>
			<img style="display:block" border="0" src="https://www.vitor.poa.br/sigre/emails/images/covid19_thiago_160.jpg" width="113" height="128" alt=""></td>
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
				$pessoas .= str_pad($codigo,7)." - ".$nome.' - '.$email.' Não foi possível enviar o e-mail <br>'. $mail->ErrorInfo;
				$data = date("Y/m/d H:i:s");
				$seq = 'NULL';	
				// insere na tabela emails enviados
				$strsql5 = "INSERT INTO `emails_enviados` VALUES (";
				$strsql5 .= $seq.",'".$data."',".$codigo.",'".$nome."','".$email."','".$mail->Subject."')";
				$resposta = $_con->query($strsql5);
				echo $strsql5."<br>";
				$enviado=false;
			}
			
		}
		$ult_enviado = $ultimo_registro + 30;		//ALTERA O ARQUIVO controle_envio
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