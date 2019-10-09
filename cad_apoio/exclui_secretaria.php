<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["campanha"];	
$strsql = "delete from `secretarias` where codigo = ".$codigo;

gravaoperacoes("secretarias","E", $_SESSION["usuarioUser"],"Excluída secretaria #: ".$codigo);

$resp = executa_sql($strsql,"Secretaria excluída com sucesso","Secretaria NÃO excluída",true,true);

?>
