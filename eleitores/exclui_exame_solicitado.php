<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança

protegePagina(); // Chama a função que protege a página

require_once("../utilitarios/funcoes.php");
$_SESSION['tab']= 7;

$id = $_GET["id"];	

$strsql = "DELETE FROM `exames` WHERE `id`= ".$id;

gravaoperacoes("exames","E", $_SESSION["usuarioUser"],"Exame excluído #: ".$id);

$retorno= executa_sql($strsql,"Exame Solicitado excluído com Sucesso","Exame NÃO excluído!",true,true);

?>