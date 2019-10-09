<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include_once("../utilitarios/funcoes.php");


$data_agenda = $_GET['data_consulta'];
$cod_clinica = $_GET['cod_clinica'];
$cod_paciente = $_GET['cod_paciente'];
$fones = $_GET['fones'];
$obs = $_GET['obs'];
$id = "NULL";	
$data_inclusao = date('Y-m-d');


// id
//$theValue = (!get_magic_quotes_gpc()) ? addslashes($id) : $id;
//$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`id`"] = "NULL";

// DATA CONSULTA
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_agenda) : $data_agenda;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$fieldList["`data_agenda`"] = $theValue;

// CLINICA
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_clinica) : $cod_clinica;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`clinica`"] = $theValue;

// PACIENTE
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_paciente) : $cod_paciente;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`cod_cadastro`"] = $theValue;

$fieldList["`situacao`"] = 1;

$fieldList["`prioridade`"] = 0;

// DATA Inclusão
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_inclusao) : $data_inclusao;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$fieldList["`data_inc_esp`"] = $theValue;

// obs
$theValue = (!get_magic_quotes_gpc()) ? addslashes($obs) : $obs;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fieldList["`observacoes`"] = $theValue;

// fones
$theValue = (!get_magic_quotes_gpc()) ? addslashes($fones) : $fones;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fieldList["`fones`"] = $theValue;

// insere no banco

$strsql = "INSERT INTO `agenda_clinica` (";
$strsql .= implode(",", array_keys($fieldList));
$strsql .= ") VALUES (";
$strsql .= implode(",", array_values($fieldList));
$strsql .= ")";

//echo '<br><br><br><br><br><br><br>'.$strsql;		

gravaoperacoes("agenda_clinica","I", $_SESSION["usuarioUser"],"Incluída a consulta paciente: ".$cod_paciente." na clinica ".$cod_clinica." em ".$data_inclusao);
			
$resposta = executa_sql($strsql,"Consulta incluída com sucesso!","ERRO ao incluir Consulta",true,true);
			
?>

