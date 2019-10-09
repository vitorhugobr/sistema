<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["origem"];	
$strsql = "delete from `origem` where Origem = ".$codigo;

gravaoperacoes("origem","E", $_SESSION["usuarioUser"],"Excluída origem #: ".$codigo);
$resp = executa_sql($strsql,"Origem excluída com sucesso","Origem NÃO excluída",true,true);
?>
