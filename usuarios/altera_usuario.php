<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");
$cod   = $_GET['codigo'];
$usuario   = $_GET['usu'];
$nivel = $_GET['niv'];
$nome  = strtoupper($_GET['nome']);
$email  = $_GET['email'];

// codigo
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod) : $cod;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$cod = $theValue;

// usuario
$theValue = (!get_magic_quotes_gpc()) ? addslashes($usuario) : $usuario;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$usuario = $theValue;

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

$_sql = 'UPDATE users SET ';
$_sql .= "usuario = ".$usuario;
$_sql .= ", nivel = ".$nivel;
$_sql .= ", nome = ".$nome;
$_sql .= ", email = ".$email;
$_sql .= ' where codigo = '.$cod;

#echo $_sql;

executa_sql($_sql,"Usuário atualizado com sucesso!","Erro na atualização do Usuário",true,false);

gravaoperacoes("users","A",$_SESSION["usuarioUser"],"Alterado usuário ".$usuario);

?>