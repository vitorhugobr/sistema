<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["profissao"];	
$strsql = "delete from `profissao` where Profissao = ".$codigo;

gravaoperacoes("profissao","E", $_SESSION["usuarioUser"],"Excluída campanha #: ".$codigo);

$resp = executa_sql_comum($strsql,"Profissão excluída com sucesso","Profissão NÃO excluído",true,true);

?>
