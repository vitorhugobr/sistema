<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de seguran�a

protegePagina(); // Chama a fun��o que protege a p�gina

$codigo = $_GET["id"];	

$strsql = "DELETE FROM `visitas` WHERE `Visita`= ".$codigo;

gravaoperacoes("visitas","E", $_SESSION["usuarioUser"],"Exclu�da visita #: ".$codigo);

executa_sql($strsql,"Exclus�o da Contato OK!","ERRO na exclus�o de contato",true,true);

?>