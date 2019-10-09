<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["id"];	
$strsql = "delete from `espera` where id = ".$codigo;

gravaoperacoes("espera","E", $_SESSION["usuarioUser"],"Excluído da lista de espera #: ".$codigo);

$resp = executa_sql($strsql,"Paciente excluído com sucesso da Lista de Espera","Paciente NÃO excluído da Lista de Espera",true,true);
?>
