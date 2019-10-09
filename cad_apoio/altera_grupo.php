<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['desc'];
$grupo = $_GET['grupo'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update grupos set NOMEGRP = ".$descricao." where GRUPO = ".$grupo;

gravaoperacoes("grupos","A", $_SESSION["usuarioUser"],"Grupo alterado #: ".$grupo);

$resp = executa_sql($_sql,"GRUPO alterado!","GRUPO NÃO alterado!",true,true);

?>

