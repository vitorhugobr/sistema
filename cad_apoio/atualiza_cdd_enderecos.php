<?php
//
date_default_timezone_set('America/Sao_Paulo');

$_SG['servidorcomum'] = "www.vitor.poa.br";
$_SG['bancocomum'] = "vitorpoa_teste";
$_SG['usuariocomum'] = "vitorpoa_user";
$_SG['senhacomum'] = "vhmo@2017";

$_con  = new mysqli($_SG['servidorcomum'],$_SG['usuariocomum'],$_SG['senhacomum'],$_SG['bancocomum']);	
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQLi " .$_SG['servidor']."<br> Erro " .
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
			$_SG['servidor'] = "191.252.101.58";
			$_SG['banco'] = "drthiago_sigre";
			$_SG['usuario'] = "sigre";
			$_SG['senha'] = "sigre2018";
			$_SG['politico'] = "Dr Thiago";
			//	senha cpanel:   usuário: 
			break;
		case 2:  // Pujol
			$_SG['servidor'] = "www.rpujol.com.br";
			$_SG['banco'] = "rpujolco_pujol";
			$_SG['usuario'] = "rpujolco_pujol";
			$_SG['senha'] = "vhm@2019";
			$_SG['politico'] = "Pujol";
			//  senha cpanel: "VHMO@@2019"  usuário: "rpujolcom"
			break;
		case 3:  // Mauro Pinheiro
			$_SG['servidor'] = "www.mauropinheiro.net.br";
			$_SG['banco'] = "mauropin_mauro";
			$_SG['usuario'] = "mauropinheironet";
			$_SG['senha'] = "UIT8765%kuyi&*";
			$_SG['politico'] = "Mauro Pinheiro";
			//	senha cpanel: "UIT8765%kuyi&*"  usuário: "mauropinheironet"
			break;
		case 4:  // Domingos Cunha
			$_SG['servidor'] = "www.domingoscunha.com.br";
			$_SG['banco'] = "domingos_domingos";
			$_SG['usuario'] = "domingos_domingo";
			$_SG['senha'] = "domi@2019";
			$_SG['politico'] = "Domingos Cunha";
			//	senha cpanel: "%Yb[2,XNP=D%"  usuário: "domingoscunhacom"
			break;
		case 5:  // Tessaro
			$_SG['servidor'] = "www.vereadortessaro.com.br";
			$_SG['banco'] = "vereador_sigre";
			$_SG['usuario'] = "vereador_tessaro";
			$_SG['senha'] = "tessaro@2019";
			$_SG['politico'] = "Tessaro";
			//	senha cpanel:    usuário: 
			break;
		case 6:  // Democratas Porto Alegre
			$_SG['servidor'] = "www.rpujol.com.br";
			$_SG['banco'] = "rpujolco_dem";
			$_SG['usuario'] = "rpujolco_dem";
			$_SG['senha'] = "democrataspoa@2019";
			$_SG['politico'] = "Dem PoA";
			//	senha cpanel: "VHMO@@2019"  usuário: "rpujolcom"
			break;
		case 7:  // Sebastião Melo
			$_SG['servidor'] = "www.sebastiaomelo.poa.br";
			$_SG['usuario'] = "sebastia_melo";
			$_SG['senha'] = "lmqY{uxa(WrL";
			$_SG['banco'] = "sebastia_sigre"; 
			$_SG['politico'] = "Sebastião Melo";
			//	senha cpanel: "=1fTUSoRJ}Ru"  usuário: "sebastiaomelopoa"
			break;
	}

	$mysqli = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	

	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$query = "select * from cdd";
	$mysql_query = $_con->query($query);
	$tot=0;
	$limpeza .= "<strong><i>".$_SG['politico'].'</i></strong><br>';
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