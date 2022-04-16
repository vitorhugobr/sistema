<?php
# Exclui os cadastros que foram incluídos e não completados
# NOME="" e GRUPO=0;

$limpeza="";
$totalexc = 0;
for ($i = 1; $i <= 4; $i++) {
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
		break;
	case 3:  //  PSC POA
        $cliente = "PSC PoA";
        $_SESSION['servidor'] = "www.vitor.poa.br";
        $_SESSION['banco'] = "vitorpoa_psc";
        $_SESSION['usuario'] = "vitorpoa_psc";
        $_SESSION['senha'] = "vhmo@2022";
        //  senha cpanel: "K_8zE{VmHQy1"  usuário: "vitorpoa"
        break;
    case 4:  // Sebastião Melo
        //$mysqli = new mysqli("www.sebastiaomelo.poa.br","sebastia_melo","lmqY{uxa(WrL","sebastia_sigre");  
        $cliente = "Melo";
        $_SESSION['servidor'] = "www.sebastiaomelo.poa.br";
        $_SESSION['banco'] = "sebastia_sigre";
        $_SESSION['usuario'] = "sebastia_melo";
        $_SESSION['senha'] = "lmqY{uxa(WrL";
      //  senha cpanel: "@H2n,?9#l0pR"  usuário: "sebastiaomelopoa"
      break;
    }
//    //echo $_SESSION['servidor']."<br>";
    //if ($cliente <> "Melo") {
        $mysqli = new mysqli($_SESSION['servidor'],$_SESSION['usuario'],$_SESSION['senha'],$_SESSION['banco']); 
    //}

//	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Conexão falhou: %s\n", mysqli_connect_error());
		exit();
	}
//
//	/* delete rows */
	$mysqli->query('DELETE from cadastro WHERE NOME="" and GRUPO=0');
//	printf("Affected rows (".$mysqli->query."): %d\n", $mysqli->affected_rows);


	$limpeza .= $cliente." = <b>".$mysqli->affected_rows."</b> registros excluídos.<br>";
    $totalexc = $totalexc + $mysqli->affected_rows;	

//	/* close connection */
	$mysqli->close();
}

//echo $limpeza;
If ($totalexc > 0){
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
}
?>