<?php
session_start();
include_once("../connections/banco.php");
//Variavel controla a necessidade de salvar no banco
$salvar_dados_bd = 1; //Valor $salvar_dados_bd = 1 deve salvar no banco / $salvar_dados_bd = 2 não salvar no banco

if(empty($_POST['id'])){
	echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http:editar_senha.php'>";	
	$_SESSION['usuario_senha_vazio'] = "Erro ao atualizar a senha. Entre em contato vhmoliveira@gmail.com";		
	$salvar_dados_bd = 2;
}

if(empty($_POST['txt_senha'])){
  if(!empty($_POST['id'])){
	$usuario_id = $_POST['id'];
	$result_usuario = "SELECT * FROM users WHERE codigo = '$usuario_id'";
	$resultado_usuario = mysqli_query($_con, $result_usuario);
	$row_usuario = mysqli_fetch_assoc($resultado_usuario);
	if(isset($row_usuario)){
		$recuperar_senha = $row_usuario['recuperar_senha'];
		echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http:editar_senha.php?chave=$recuperar_senha'>";	
		$_SESSION['usuario_senha_vazio'] = "Campo senha é obrigatorio!";
	}
  }
  $salvar_dados_bd = 2;
}else{
  $_SESSION['value_senha'] = $_POST['txt_senha'];
}
if($salvar_dados_bd == 1){
  $txt_senha = mysqli_real_escape_string($_con, $_POST['txt_senha']);
  $txt_senha = md5($txt_senha);
  $id = mysqli_real_escape_string($_con, $_POST['id']);
  $result_usuario = "UPDATE users SET senha='$txt_senha', recuperar_senha = '' WHERE codigo = $id";
  $resultado_usuario = mysqli_query($_con, $result_usuario);	
  unset($_SESSION['value_senha']);
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
</head>

<body>
<?php
  if(mysqli_affected_rows($_con) != 0){
	  $_SESSION['loginSaida'] = "Senha alterada com sucesso.";
	  echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http:../index.php'>";	
  }else{
	  $_SESSION['recuperar_senha'] = "Erro ao atualizar a senha. Entre em contato vhmoliveira@gmail.com";
	  echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http:editar_senha.php'>";	
  } 
}else{
	
}
$_con->close(); 
?>
</body>
</html>
