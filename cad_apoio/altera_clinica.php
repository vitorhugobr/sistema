<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['desc'];
$clinica = $_GET['clinica'];
$endereco =  $_GET['endereco'];
$telefone = $_GET['fone'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update clinicas set clinica = ".$descricao.", endereco = ".$endereco.", telefone = ".$telefone." where id = ".$clinica;

gravaoperacoes("clinicas","A", $_SESSION["usuarioUser"],"Clínica alterada #: ".$clinica);

$resp = executa_sql($_sql,"Clínica alterada!","Clínica NÃO alterada!",true,true);

?>

