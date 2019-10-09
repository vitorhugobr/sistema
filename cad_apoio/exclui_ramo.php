<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["ramo"];	
$strsql = "delete from `ramo` where CODIGO = ".$codigo;

gravaoperacoes("ramo","E", $_SESSION["usuarioUser"],"Excluído ramo #: ".$codigo);

$resp = executa_sql_comum($strsql,"Ramo excluído com sucesso","Ramo NÃO excluído",true,true);
?>
