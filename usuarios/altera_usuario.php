<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");
$cod   = $_GET['codigo'];
$usuario   = $_GET['usu'];
$nivel = $_GET['niv'];
$nome  = strtoupper($_GET['nome']);
$email  = $_GET['email'];
$mudou = $_GET['mudou'];
$usuario_original = $_GET['usuario_original'];
// codigo
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod) : $cod;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$cod = $theValue;

// mudou
$theValue = (!get_magic_quotes_gpc()) ? addslashes($mudou) : $mudou;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$mudou = $theValue;

// usuario
$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario) : $usuario;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$usuario = $theValue;

// usuario_original
$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario_original) : $usuario_original;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$usuario_original = $theValue;

// nivel
$theValue = (!get_magic_quotes_gpc()) ? addslashes($nivel) : $nivel;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$nivel = $theValue;

// NOME
$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome) : $nome;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$nome = $theValue;

// email
$theValue = (!get_magic_quotes_gpc()) ? addslashes($email) : $email;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$email = $theValue;

if ($mudou==1){
	$_sqlu = 'UPDATE liberacao SET ';
	$_sqlu .= "username = ".$usuario;
	$_sqlu .= ' where username = '.$usuario_original;
	executa_sql($_sqlu,"","",false,false);
	gravaoperacoes("users","A",$_SESSION["usuarioUser"],"Alteradas liberacões do ".$usuario_original." para usário ".$usuario);
}

$_sql = 'UPDATE users SET ';
$_sql .= "usuario = ".$usuario;
$_sql .= ", nivel = ".$nivel;
$_sql .= ", nome = ".$nome;
$_sql .= ", email = ".$email;
$_sql .= ' where codigo = '.$cod;

#echo $_sql;

executa_sql($_sql,"Usuário atualizado com sucesso!","Erro na atualização do Usuário",true,true);

gravaoperacoes("users","A",$_SESSION["usuarioUser"],"Alterado usuário ".$usuario);

?>