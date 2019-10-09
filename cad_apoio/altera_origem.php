<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	

$descricao = $_GET['desc'];
$origem = $_GET['origem'];

$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Update origem set Descricao = ".$descricao." where Origem = ".$origem;

gravaoperacoes("origem","A", $_SESSION["usuarioUser"],"Origem alterada #: ".$origem);

$resp = executa_sql($_sql,"Origem alterada com sucesso!","Origem NÃO alterada!", true, true);

?>