<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include_once("../utilitarios/funcoes.php");


$data_consulta = $_GET['data_consulta'];
$cod_clinica = $_GET['cod_clinica'];
$cod_paciente = $_GET['cod_paciente'];
$fones = $_GET['fones'];
$obs = $_GET['obs'];
$id = "NULL";	
$data_inclusao = date('Y-m-d');
$status = 0;

// id
//$theValue = (!get_magic_quotes_gpc()) ? addslashes($id) : $id;
//$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`id`"] = "NULL";

// CLINICA
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_clinica) : $cod_clinica;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`clinica`"] = $theValue;

// DATA Inclusão
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_inclusao) : $data_inclusao;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$fieldList["`data_inclusao`"] = $theValue;

// DATA CONSULTA
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_consulta) : $data_consulta;
$theValue = ($theValue != "") ? " '" . FormatDateTime($theValue,5) . "'" : "NULL";
$fieldList["`data_consulta`"] = $theValue;


// PACIENTE
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_paciente) : $cod_paciente;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`cod_cadastro`"] = $theValue;

// fones
$theValue = (!get_magic_quotes_gpc()) ? addslashes($fones) : $fones;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fieldList["`fones`"] = $theValue;

// obs
$theValue = (!get_magic_quotes_gpc()) ? addslashes($obs) : $obs;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fieldList["`observacoes`"] = $theValue;

// STATUS
$theValue = (!get_magic_quotes_gpc()) ? addslashes($status) : $status;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fieldList["`status`"] = $theValue;

// insere no banco

$strsql = "INSERT INTO `espera` (";
$strsql .= implode(",", array_keys($fieldList));
$strsql .= ") VALUES (";
$strsql .= implode(",", array_values($fieldList));
$strsql .= ")";


//echo '<br><br><br><br><br><br><br>'.$strsql;		

gravaoperacoes("espera","I", $_SESSION["usuarioUser"],"Incluída a lista paciente: ".$cod_paciente." na clinica ".$cod_clinica." em ".$data_inclusao);
			
$resposta = executa_sql($strsql,"Lista de Espera incluída com sucesso!","ERRO ao incluir Lista de Espera",true,true);
			
?>

