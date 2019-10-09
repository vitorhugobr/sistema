<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['desc'];
$secretaria = $_GET['secretaria'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update secretarias set descricao = ".$descricao." where codigo = ".$secretaria;

gravaoperacoes("secretaria","A", $_SESSION["usuarioUser"],"secretaria #: ".$secretaria);

$resp = executa_sql($_sql,"Secretaria alterada!","Secretaria NÃO alterada!",true,true);


?>

