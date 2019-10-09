<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["id"];	
$strsql = "delete from `agenda_clinica` where id = ".$codigo;

gravaoperacoes("agenda_clinica","E", $_SESSION["usuarioUser"],"Excluída consulta #: ".$codigo);

$resp = executa_sql($strsql,"Consulta excluída com sucesso","Consulta NÃO excluída",true,true);
?>
