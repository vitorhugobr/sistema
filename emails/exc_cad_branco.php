<?php
# Exclui os cadastros que foram incluídos e não completados
# NOME="" e GRUPO=0;

$limpeza="";

for ($i = 1; $i <= 8; $i++) {
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
		case 8:  // Luiz Braz
			$_SG['servidor'] = "www.vitor.poa.br";
			$_SG['usuario'] = "vitorpoa_luiz";
			$_SG['senha'] = "braz@2020";
			$_SG['banco'] = "vitorpoa_luizbraz"; 
			//	senha cpanel: "=1fTUSoRJ}Ru"  usuário: "sebastiaomelopoa"
			break;
	}

	$mysqli = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	

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

	$limpeza .= $_SG['politico']." = ".$mysqli->affected_rows." registros excluídos.<br>";

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