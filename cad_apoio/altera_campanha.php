<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['desc'];
$campanha = $_GET['campanha'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update campanha set descricao = ".$descricao." where codigo = ".$campanha;

gravaoperacoes("campanha","A", $_SESSION["usuarioUser"],"campanha #: ".$campanha);

$resp = executa_sql($_sql,"Campanha alterada!","campanha NÃO alterada!",true,true);


?>

