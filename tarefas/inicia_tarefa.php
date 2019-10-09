<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');

//			busca os valores dos parâmetros
$codigo = $_GET["tarefa"];		 
$dtinicio = new DateTime();
$dtinicio = $dtinicio->format( "d/m/Y H:i" );

// CODIGO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($codigo) : $codigo;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$codigo = $theValue;

// DTCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtinicio) : $dtinicio;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$dtinicio = $theValue;

// altera no banco

$strsql = 'UPDATE tarefas SET ';
$strsql .= "data_inicio =".$dtinicio;
$strsql .= ' WHERE id='.$codigo;

$ret = executa_sql($strsql,"","",false,false);

$strsql3 = "INSERT INTO historico_tarefas values(NULL,".$codigo.",".$dtinicio.",'* INICIADA *')";

$ret2 = executa_sql($strsql3,"Tarefa iniciada com sucesso!","Tarefa NÃO iniciada",true,true);
$_SESSION['mudoutarefa'] = false;

?>