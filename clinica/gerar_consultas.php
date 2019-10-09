<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

$cod_clinica = $_GET['cod_clinica'];
$data_consulta = $_GET['data_consulta'];
$data_inc_esp = $_GET['data_inc_esp'];
$cod_cadastro = $_GET['cod_cadastro']; 
$fones = $_GET['fones']; 
$observacoes = $_GET['observacoes']; 

$id_new = NULL;
// id para inclusão
$id = $_GET['id'];

$theValue = (!get_magic_quotes_gpc()) ? addslashes($id_new) : $id_new;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$id_new = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($id) : $id;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$id = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_clinica) : $cod_clinica;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$cod_clinica = $theValue;

// inclusão
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_cadastro) : $cod_cadastro;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$cod_cadastro = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_consulta) : $data_consulta;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$data_consulta = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_inc_esp) : $data_inc_esp;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$data_inc_esp = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($observacoes) : $observacoes;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$observacoes = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($fones) : $fones;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fones = $theValue;

$strsql = "INSERT INTO `agenda_clinica` VALUES(";
$strsql .= $id_new;
$strsql .= ",".$data_consulta;
$strsql .= ",".$cod_clinica;
$strsql .= ",".$cod_cadastro;
$strsql .= ",1 ";
$strsql .= ",0";
$strsql .= ",".$data_inc_esp;
$strsql .= ",".$observacoes;
$strsql .= ",".$fones;
$strsql .= ",0";
$strsql .= ")";
 

//echo '<br><br><br>'.$strsql.'<br>';
executa_sql($strsql,"OK","Erro",false,false);
gravaoperacoes("agenda_clinica","I", $_SESSION["usuarioUser"],"Incluído agenda #: ".$id_new);
$strsql2 = 'DELETE FROM `espera` WHERE id = '.$id;
//echo $strsql2."<br>";
executa_sql($strsql2,"Consultas geradas com sucesso","ERRO",false,true);
?>
