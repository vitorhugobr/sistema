<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include_once("../utilitarios/funcoes.php");

protegePagina(); // Chama a função que protege a página
	
$cod   = $_GET['cod'];
$senha   = md5($_GET['senha']);

// codigo
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod) : $cod;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$cod = $theValue;

// senha
$theValue = (!get_magic_quotes_gpc()) ? addslashes($senha) : $senha;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$senha = $theValue;

$_sql = 'UPDATE users SET ';
$_sql .= "senha = ".$senha;
$_sql .= ' where codigo = '.$cod;

//echo $_sql;

$trocou = executa_sql($_sql,"Senha Alterada","Senha NÃO alterada",true,true);

?>