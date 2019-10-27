<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança


protegePagina(); // Chama a função que protege a página

require_once("../utilitarios/funcoes.php");

$codigo = $_GET["id"];	

$strsql = "DELETE FROM `visitas` WHERE `Visita`= ".$codigo;

gravaoperacoes("visitas","E", $_SESSION["usuarioUser"],"Excluída visita #: ".$codigo);

$retorno= executa_sql($strsql,"Contato excluído com Sucesso","Contato NÃO excluído!",false,false);

?>