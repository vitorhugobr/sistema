<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança

protegePagina(); // Chama a função que protege a página

require_once("../utilitarios/funcoes.php");
$_SESSION['tab']= 6;

$codigo = $_GET["id"];	

$strsql = "DELETE FROM `dados_receita` WHERE `id`= ".$codigo;

gravaoperacoes("remedios","E", $_SESSION["usuarioUser"],"exclui remedio #: ".$codigo);


$retorno= executa_sql($strsql,"Medicamento excluído com Sucesso","Medicamento NÃO excluído!",true,true);
?>