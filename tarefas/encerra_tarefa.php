<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include ("../utilitarios/funcoes.php");


//			busca os valores dos parâmetros
$codigo = $_GET["tarefa"];		
$dtfim = new DateTime();
$dtfim = $dtfim->format( "d/m/Y H:i" );
 

// CODIGO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($codigo) : $codigo;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$codigo = $theValue;

// DTCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtfim) : $dtfim;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$dtfim = $theValue;
// altera no banco

$strsql = 'UPDATE tarefas SET ';
$strsql .= "data_fim =".$dtfim;
$strsql .= ", status =1";
$strsql .= ' WHERE id='.$codigo;

/*echo '<script>alert("'.$strsql.'");</script>';
*/

$_res = executa_sql($strsql,"","",false,false);

$strsql3 = "INSERT INTO historico_tarefas values(NULL,".$codigo.",".$dtfim.",'Finalizada')";

$_res3 = executa_sql($strsql3,"Tarefa encerrada com sucesso","Tarefa NÃO encerrada",true,true);
//fecha conexão
$_SESSION['mudoutarefa'] = true;


?>