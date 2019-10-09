<?php
session_start();
include_once("../connections/banco.php");
include("../phpmailer527/PHPMailerAutoload.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Recuperar senhas">
<meta name="author" content="Vitor H M Oliveira">
<link rel="icon" href="imagens/favicon.ico">
<title><?php echo $_SESSION['sistemaabrev']?> - Recuperação de Senha</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/signin.css" rel="stylesheet">
<script src="../js/ie-emulation-modes-warning.js"></script>
</head>
<body>
<?php
$salvar_dados_bd = 1; //Valor $salvar_dados_bd = 1 deve salvar no banco / $salvar_dados_bd = 2 não salvar no banco
$erro = false;
if(empty($_POST['txt_email'])){
  echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=recuperar_senha.php'>";	
  $_SESSION['usuario_email_vazio'] = "Campo e-mail é obrigatorio!";		
  $salvar_dados_bd = 2;
}else{
  $_SESSION['value_email'] = $_POST['txt_email'];
}
if($salvar_dados_bd == 1){
  $txt_email = mysqli_real_escape_string($_con, $_POST['txt_email']);
  $resul_usuario = "SELECT * FROM users WHERE email = '$txt_email'";
//	echo $resul_usuario.'<br>';
  $resultado_usuario = mysqli_query($_con, $resul_usuario);
  $linhas = mysqli_affected_rows($_con);
  if ($linhas > 0){
	$row_usuario = mysqli_fetch_assoc($resultado_usuario);
	$codigo = $row_usuario['codigo'];
	$email = $row_usuario['email'];
	$usuario = $row_usuario['usuario'];
	$nome = strtoupper($row_usuario['nome']);
	$recuperar_senha = time();
	$recuperar_senha = $recuperar_senha."V".$codigo;
	$recuperar_senha = md5($recuperar_senha);
	$result_situacoes = "UPDATE users SET recuperar_senha='$recuperar_senha' WHERE codigo = $codigo";
	$resultado_situacoes = mysqli_query($_con, $result_situacoes);	
	unset($_SESSION['value_email']);
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->isHTML(true);
	$Mailer->Charset = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Host = 'empregosnainternet.com.br';
	$Mailer->Port = 587;
	$Mailer->Username = 'folder';
	$Mailer->Password = 'cfcd378b6';
	$Mailer->From = $_SESSION['email_pol'];
	$Mailer->FromName = 'Sistema SIGRE';
//	$Mailer->Bcc = "vhmoliveira@yahoo.com.br";
	$titulo = "Recupera&ccedil;&atilde;o de senha";
	$titulo=htmlentities($titulo);
	$Mailer->Subject = $titulo;
	$mensagem = "Olá <strong>$nome</strong><br><br>";
	$mensagem .= "Voc&ecirc; solicitou uma recupera&ccedil;&atilde;o de senha no Sistema SIGRE.<br>";
	$mensagem .= "Para continuar o processo de recupera&ccedil;&atilde;o de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador.<br><br>";
	$mensagem .= "<a href='".$_SESSION['url']."senhas/editar_senha.php?chave=".$recuperar_senha."'>".$_SESSION['url']."senhas/editar_senha.php?chave=".$recuperar_senha."</a><br><br>";
	$mensagem .= "Usuário: ".$usuario."<br><br>";
	$mensagem .= "Se você não solicitou essa altera&ccedil;&atilde;o, nenhuma a&ccedil;&atilde;o é necess&aacute;ria.<br>Sua senha permanecer&aacute; a mesma at&eacute; que voc&ecirc; ative este c&oacute;digo.<br><br>";
	$mensagem .= "Atenciosamente, Sistema SIGRE.";
	$mensagem .= "<br><strong>Favor NÂO responder a este e-mail</strong>";
	//echo $mensagem;
	$Mailer->Body = $mensagem;  
	$Mailer->AltBody = 'conteudo do E-mail em texto';//Corpo da mensagem em texto
	$Mailer->AddAddress($email);//Destinatario 
	if(!$Mailer->Send()){
	  $_SESSION['recuperar_senha'] = "Instruções de redefinição de senha NÃO foram enviadas para o seu e-mail. Entre em contato com vhmoliveira@gmail.com<br>Erro -> ". $Mailer->ErrorInfo;
		echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=recuperar_senha.php'>";	
	}else{
	  $_SESSION['loginSaida'] = "Instruções de redefinição de senha foram enviadas para o seu e-mail com Sucesso.";
	  echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../index.php'>";
	}
}else{
	$_SESSION['recuperar_senha'] = "<br>E-mail não cadastrado.<br>";
	echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=recuperar_senha.php'>";	
  }
}
$_con->close(); ?>
</body>
</html>