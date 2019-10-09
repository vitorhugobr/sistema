<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

require_once("../utilitarios/funcoes.php");
$_SESSION['tab']= 2;

$codigo = $_GET["id"];	

$strsql = "delete from `enderecos` where id = ".$codigo;

gravaoperacoes("enderecos","E", $_SESSION["usuarioUser"],"Excluído endereco do #: ".$codigo);

$resposta = executa_sql($strsql,"Exclusão de endereço realizado com sucesso!","ERRO na exclusao do endereco",true,true);

?>