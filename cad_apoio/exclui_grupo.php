<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["grupo"];	
$strsql = "delete from `grupos` where GRUPO = ".$codigo;

gravaoperacoes("grupos","E", $_SESSION["usuarioUser"],"Excluído grupo #: ".$codigo);

$resp = executa_sql($strsql,"Grupo excluído com sucesso","Grupo NÃO excluído",true,true);

?>
