<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["campanha"];	
$strsql = "delete from `campanha` where codigo = ".$codigo;

gravaoperacoes("campanha","E", $_SESSION["usuarioUser"],"Excluída campanha #: ".$codigo);

$resp = executa_sql($strsql,"Campanha excluída com sucesso","Campanha NÃO excluída",true,true);

?>
