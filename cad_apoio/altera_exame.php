<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	
$descricao = $_GET['descricao'];
$id = $_GET['id'];
	// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update cadastro_exames set descricao = ".$descricao." where id = ".$id;

gravaoperacoes("exames","A", $_SESSION["usuarioUser"],"Exame alterado #: ".$id." - ".$descricao);

$resp = executa_sql($_sql,"Exame alterado!","exame NÃO alterado!",true,true);

?>

