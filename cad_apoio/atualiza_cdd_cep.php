<?php
$_SESSION['servidor'] = "www.vitor.poa.br";
$_SESSION['banco'] = "vitorpoa_teste";
$_SESSION['usuario'] = "vitorpoa_user";
$_SESSION['senha'] = "vhmo@2017";
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
$horaini = date("d-m-Y H:i:s");
$query = "select * from cdd";
$mysql_query = $_con->query($query);
$tot=0;
$atualizados="";
$limpeza="";
while ($dados_s = $mysql_query->fetch_assoc()) {
	$cepi = $dados_s["inicial"];
	$cepf = $dados_s["final"];
	$reg = $dados_s["reg"];
	$strsql = 'UPDATE cep SET ';
	$strsql .= "REG =".$reg;
	$strsql .= " WHERE CEP BETWEEN $cepi AND $cepf;";
	$_con->query($strsql);
	if ($_con->affected_rows>0) {
			$limpeza .= "<strong> ".str_pad($mysqli->affected_rows,3)."</strong> CEPS atualizados da ".$reg."<br>";
	}	 
}

require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");
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
if ($limpeza=="") {
	$limpeza = "Nenhum registro alterado!";
}
$atualizados = '<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Atualização do Cadastro de CEPs</title>
</head>
<body>
<pre>
<h2>Atualização de CDD no Cadastro de CEPs</h2>
<strong>Início da execução em  '.$horaini.':</strong><br>'.$limpeza.'<br>Final: '.date("d-m-Y H:i:s").'<br><br>atualiza_cdd_cep.php
</pre>
</body>
</html>';	

$mail->From = 'sigre@vitor.poa.br'; # e-mail remetente
$mail->FromName = 'Sistema SIGRE'; // nome remetente
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->AddAddress("vhmoliveira@gmail.com", "Vitor H M Oliveira"); # Os campos podem ser substituidos por variáveis
$mail->Subject = "Atualização CEPs - $politico"; # Assunto da mensagem
$mail->setFrom('sigre@vitor.poa.br', 'Sistema SIGRE');		
$mail->Body    = stripslashes($atualizados);
$mail->AltBody = stripslashes($atualizados);
$enviado = $mail->Send();
if ($enviado) {
	echo "Atualização de CEPs com sucesso! E-mail enviado";
} else {
	echo "Não foi possível enviar atualização de CEPs.";
	echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}
?>