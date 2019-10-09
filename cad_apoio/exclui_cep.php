<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["cep"];	
$strsql = "delete from `cep` where CEP = ".$codigo;

gravaoperacoes("ceps","E", $_SESSION["usuarioUser"],"Excluídoi cep #: ".$codigo);
$resp = executa_sql_comum($strsql,"Registro excluído com sucesso","Exclusão NÃO realizada",true,true);
?>
