<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");

$strsql = "Delete from users where usuario IS NULL";
executa_sql($strsql,"Usuário excluído com sucesso!","ERRO ao excluir: Usuário",false,true);

?>