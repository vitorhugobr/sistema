<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$id = $_GET["id"];	
$strsql = "delete from `cadastro_exames` where id = ".$id;

gravaoperacoes("cadastro_exames","E", $_SESSION["usuarioUser"],"Excluído exame #: ".$codigo);

$resp = executa_sql($strsql,"Exame excluído com sucesso","Exame NÃO excluído",true,true);

?>
