<?php
//
date_default_timezone_set('America/Sao_Paulo');

$_SESSION['servidorcomum'] = "www.vitor.poa.br";
$_SESSION['bancocomum'] = "vitorpoa_teste";
$_SESSION['usuariocomum'] = "vitorpoa_user";
$_SESSION['senhacomum'] = "vhmo@2017";

$_con  = new mysqli($_SESSION['servidorcomum'],$_SESSION['usuariocomum'],$_SESSION['senhacomum'],$_SESSION['bancocomum']);	
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQLi " .$_SESSION['servidor']."<br> Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
mysqli_set_charset($_con,"utf8");
mysqli_query($_con, "SET NAMES 'utf8'");
mysqli_query($_con, 'SET character_set_connection=utf8');
mysqli_query($_con, 'SET character_set_client=utf8');
mysqli_query($_con, 'SET character_set_results=utf8');
$limpeza="";
$horaini = date("d-m-Y H:i:s");
for ($i = 1; $i <= 7; $i++) {
	switch ($i) {
	case 1:  //Dr Thiago
		$cliente = "Dr Thiago";
		$_SESSION['servidor'] = "191.252.101.58";
		$_SESSION['banco'] = "drthiago_sigre";
		$_SESSION['usuario'] = "sigre";
		$_SESSION['senha'] = "sigre2018";
		//	senha cpanel:   usuário: 
		break;
	case 2:  // Emerson
		$cliente = "Emerson Correa";
		$_SESSION['servidor'] = "www.serverwebdb.com.br";
		$_SESSION['banco'] = "chaplinb_chaplin";
		$_SESSION['usuario'] = "chaplinb_chaplin";
		$_SESSION['senha'] = "HpcOKYN7b2E-";
		//	senha cpanel: "QjT#mW@TxWgJ"  usuário: "chaplinbebidasco"		
		break;
	case 3:  // Mauro Pinheiro
		break;
	case 4:  // PSC Porto Alegre
		$cliente = "PSC PoA";
		$_SESSION['servidor'] = "www.vitor.poa.br";
		$_SESSION['banco'] = "vitorpoa_psc";
		$_SESSION['usuario'] = "vitorpoa_psc";
		$_SESSION['senha'] = "vhmo@2022";
		//	senha cpanel: "K_8zE{VmHQy1"  usuário: "vitorpoa"
		break;
	case 5:  // 
		break;
	case 6:  // 
		break;
	case7:  // Sebastião Melo
		$cliente = "Sebastião Melo";
		$_SESSION['servidor'] = "www.sebastiaomelo.poa.br";
		$_SESSION['usuario'] = "sebastia_melo";
		$_SESSION['senha'] = "lmqY{uxa(WrL";
		$_SESSION['banco'] = "sebastia_sigre"; 
		//	senha cpanel: "@H2n,?9#l0pR"  usuário: "sebastiaomelopoa"
		break;

	}

	$mysqli = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	

	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$query = "select * from cdd";
	$mysql_query = $_con->query($query);
	$tot=0;
	$limpeza .= "<strong><i>".$cliente.'</i></strong><br>';
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$cepi = $dados_s["inicial"];
		$cepf = $dados_s["final"];
		$reg = $dados_s["reg"];

		$strsql = 'UPDATE enderecos SET ';
		$strsql .= "reg =".$reg;
		$strsql .= " WHERE cep BETWEEN $cepi AND $cepf";

		/* delete rows */
		$mysqli->query($strsql);
		$tot += $mysqli->affected_rows;
		if ($mysqli->affected_rows>0) {
			$limpeza .= "<strong> ".str_pad($mysqli->affected_rows,3)."</strong> registros da região ".$reg."<br>";
		}	 
		/* close connection */
	}
	$limpeza .= " <i>".$tot.'</i> registros alterados<br>';
	$mysqli->close();
}
require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");

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
$mail->From = "sigre@vitor.poa.br"; # Seu e-mail
$mail->FromName = "Sistema Sigre"; // Seu nome
# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML

# Define os destinatário(s)
$mail->AddAddress("vhmoliveira@gmail.com", "Vitor H M Oliveira"); # Os campos podem ser substituidos por variáveis
#$mail->addBCC("vhmoliveira@gmail.com","Vitor H M Oliveira");
/* assunto */
# Define a mensagem (Texto e Assunto)
$mail->Subject = "Atualização CDDs SIGRE "; # Assunto da mensagem
if ($limpeza=="") {
	$limpeza = "Nenhum registro alterado!";
}

$mensagem = '<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Atualização CDDs do Cadastro de Endereços</title>
</head>
<body>
<pre>
<h2>Atualização CDDs do Cadastro</h2>
<strong>Início da execução em  '.$horaini.':</strong><br>'.$limpeza.'<br>Final: '.date("d-m-Y H:i:s").'<br><br>atualiza_cdd_enderecos.php
</pre>
</body>
</html>';	
$mail->setFrom($email_pol, $politico);
$mail->Body    = stripslashes($mensagem);
$mail->AltBody = stripslashes($mensagem);
#echo stripslashes($mensagem);
#echo "<br>";
$enviado = $mail->Send();
if ($enviado){
	echo "E-mail enviado com sucesso!";
} else {
	echo "Não foi possível enviar o e-mail final.";
	echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}




?>