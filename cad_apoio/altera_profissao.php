<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['desc'];
$profissao = $_GET['profissao'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update profissao set Descricao2 = ".$descricao." where Profissao = ".$profissao;

gravaoperacoes("profissao","A", $_SESSION["usuarioUser"],"Profissão alterada #: ".$profissao);

$resp = executa_sql_comum($_sql,"PROFISSÃO alterada com sucesso!","PROFISSÃO NÃO alterada!",true,true);

?>

