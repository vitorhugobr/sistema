<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['desc'];
$ramo = $_GET['ramo'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update ramo set DESCRICAO = ".$descricao." where CODIGO = ".$ramo;

gravaoperacoes("ramo","A", $_SESSION["usuarioUser"],"Ramo alterado #: ".$ramo);

$resp = executa_sql_comum($_sql,"RAMO alterado com sucesso!","RAMO NÃO alterado!",true,true);

?>

