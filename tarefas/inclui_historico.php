<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');

$tarefa = $_GET['id_tarefa'];
$datahistorico= $_GET['data_hist'];
$historico = strtoupper($_GET['descricao_hist']);

// id_historico
$id = "NULL";

// tarefa
$theValue = (!get_magic_quotes_gpc()) ? addslashes($tarefa) : $tarefa;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$tarefa = $theValue;

// historico
$theValue = (!get_magic_quotes_gpc()) ? addslashes($historico) : $historico;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$historico = $theValue;

// DTCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($datahistorico) : $datahistorico;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$datahistorico = $theValue;

$_sql = "Insert into historico_tarefas values(".$id.",".$tarefa.",".$datahistorico.",".$historico.")";

//echo $_sql;

$ret = executa_sql($_sql,"Histórico de Tarefa incluído com sucesso","Histórico de Tarefa NÃO incluído",true,true);

echo '<script>self.window.close();</script>';
$_SESSION['mudoutarefa'] = false;
?>