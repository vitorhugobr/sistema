<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança

protegePagina(); // Chama a função que protege a página

require_once("../utilitarios/funcoes.php");
$_SESSION['tab']= 6;

$codigo = $_GET["id"];	

$strsql = "DELETE FROM `receituario` WHERE `id`= ".$codigo;

gravaoperacoes("receituario","E", $_SESSION["usuarioUser"],"excluiu receituário #: ".$codigo);

$retorno= executa_sql($strsql,"Receituario excluído com Sucesso","Receituario NÃO excluído!",true,true);

?>