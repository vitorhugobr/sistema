<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de seguranзa

protegePagina(); // Chama a funзгo que protege a pбgina

$codigo = $_GET["id"];	

$strsql = "DELETE FROM `visitas` WHERE `Visita`= ".$codigo;

gravaoperacoes("visitas","E", $_SESSION["usuarioUser"],"Excluнda visita #: ".$codigo);

executa_sql($strsql,"Exclusгo da Contato OK!","ERRO na exclusгo de contato",true,true);

?>