<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");
$cod   = $_GET['cod'];

$strsql = "Delete from users where codigo = ".$cod;
executa_sql($strsql,"Usuário excluído com sucesso!","ERRO ao excluir: Usuário",false,true);

?>