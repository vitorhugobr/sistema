<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança

protegePagina(); // Chama a função que protege a página
$_SESSION['tab']= 7;

require_once("../utilitarios/funcoes.php");

$id = $_GET["id"];	

$strsql = "DELETE FROM `exames_itens` WHERE `id_exame`= ".$id;

$retorno= executa_sql($strsql,"Exame excluído com Sucesso","Exame NÃO excluído!",false,false);

$strsql1 = "DELETE FROM `exames` WHERE `id`= ".$id;

gravaoperacoes("exames","E", $_SESSION["usuarioUser"],"Exame excluído #: ".$id);

$retorno1= executa_sql($strsql1,"Exame excluído com Sucesso","Exame NÃO excluído!",true,true);

?>