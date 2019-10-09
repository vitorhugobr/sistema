<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");
$codigo = $_GET["id"];	
$strsql = "delete from `historico_tarefas` where cod_tarefa = ".$codigo;

$ret1 = executa_sql($strsql,"","",false,false);
$_SESSION['mudoutarefa'] = true;

$strsql2 = "delete from `tarefas` where id = ".$codigo;

$ret2 =  executa_sql($strsql2,"TAREFA excluída","TAREFA NÃO excluída!",true,true);

?>
