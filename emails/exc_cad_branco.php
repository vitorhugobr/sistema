<?php
# Exclui os cadastros que foram incluídos e não completados
# NOME="" e GRUPO=0;

$limpeza="";

for ($i = 1; $i <= 7; $i++) {
	switch ($i) {
	case 1:  //Dr Thiago
		$_SESSION['servidor'] = "191.252.101.58";
		$_SESSION['banco'] = "drthiago_sigre";
		$_SESSION['usuario'] = "sigre";
		$_SESSION['senha'] = "sigre2018";
		//	senha cpanel:   usuário: 
		break;
	case 2:  // Pujol
		$_SESSION['servidor'] = "www.rpujol.com.br";
		$_SESSION['banco'] = "rpujolco_pujol";
		$_SESSION['usuario'] = "rpujolco_pujol";
		$_SESSION['senha'] = "vhm@2019";
		//  senha cpanel: "@H2n,?9#l0pR"  usuário: "rpujolcom"
		break;
	case 3:  // Mauro Pinheiro
		$_SESSION['servidor'] = "www.mauropinheiro.net.br";
		$_SESSION['banco'] = "mauropin_mauro";
		$_SESSION['usuario'] = "mauropin_mauro";
		$_SESSION['senha'] = "vitor@2020";
		//	senha cpanel: "ae(Zx!Ncjt^7"  usuário: "mauropinheironet"
		break;
	case 4:  // Tessaro
		$_SESSION['servidor'] = "www.vereadortessaro.com.br";
		$_SESSION['banco'] = "vereador_sigre";
		$_SESSION['usuario'] = "vereador_tessaro";
		$_SESSION['senha'] = "tessaro@2019";
		//	senha cpanel: "cKGm;!X$aNdZ"    usuário: "vereadortessaroc"
		break;
	case 5:  // Democratas Porto Alegre
		$_SESSION['servidor'] = "www.rpujol.com.br";
		$_SESSION['banco'] = "rpujolco_dem";
		$_SESSION['usuario'] = "rpujolco_dem";
		$_SESSION['senha'] = "democrataspoa@2019";
		//	senha cpanel: "VHMO@@2019"  usuário: "rpujolcom"
		break;
	case 6:  // Sebastião Melo
		$_SESSION['servidor'] = "www.sebastiaomelo.poa.br";
		$_SESSION['usuario'] = "sebastia_melo";
		$_SESSION['senha'] = "lmqY{uxa(WrL";
		$_SESSION['banco'] = "sebastia_sigre"; 
		//	senha cpanel: "@H2n,?9#l0pR"  usuário: "sebastiaomelopoa"
		break;
	case 7:  // Luiz Braz
		$_SESSION['servidor'] = "www.vitor.poa.br";
		$_SESSION['usuario'] = "vitorpoa_luiz";
		$_SESSION['senha'] = "braz@2020";
		$_SESSION['banco'] = "vitorpoa_luizbraz"; 
		//	senha cpanel: "K_8zE{VmHQy1"  usuário: "vitorpoa"
		break;
	}
    echo $_SESSION['servidor']."<br>";
	$mysqli = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']);	

	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	/* delete rows */
	$mysqli->query('DELETE from cadastro WHERE NOME="" and GRUPO=0');
	# printf("Affected rows (DELETE): %d\n", $mysqli->affected_rows);

	require_once("../phpmailer/class.phpmailer.php");
	require_once("../phpmailer/class.smtp.php");

	$limpeza .= $_SESSION['servidor']." = ".$mysqli->affected_rows." registros excluídos.<br>";

	/* close connection */
	$mysqli->close();
}
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
$mail->Subject = "Limpeza Cadastros SIGRE "; # Assunto da mensagem
$mensagem = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Exclusão do Cadastro</title>
</head>
<body>
<strong>Execução em  '.date("d/m/Y").':</strong><br>'.$limpeza.'
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