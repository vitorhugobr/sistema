<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include_once("../utilitarios/funcoes.php");

$codigo = $_GET['codigo'];
$data = $_GET['data'];
$assunto = $_GET['assunto'];
$_SESSION['tab']= 3;
		 
$visita = "NULL";	
echo '<script>self.window.close();</script>';

// VISITA
$theValue = (!get_magic_quotes_gpc()) ? addslashes($visita) : $visita;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`VISITA`"] = $theValue;

// CODIGO
$theValue = (!get_magic_quotes_gpc()) ? addslashes($codigo) : $codigo;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$fieldList["`VISITANTE`"] = $theValue;

// DATA
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data) : $data;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$fieldList["`DATADAVISITA`"] = $theValue;

// ASSUNTYO
$theValue = (!get_magic_quotes_gpc()) ? addslashes($assunto) : $assunto;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fieldList["`ASSUNTO`"] = $theValue;

// insere no banco

$strsql = "INSERT INTO `visitas` (";
$strsql .= implode(",", array_keys($fieldList));
$strsql .= ") VALUES (";
$strsql .= implode(",", array_values($fieldList));
$strsql .= ")";

gravaoperacoes("visitas","I", $_SESSION["usuarioUser"],"Incluída visita #: ".$codigo);
			
$resposta = executa_sql($strsql,"Contato/Visitas incluída com sucesso!","ERRO ao incluir contato/visita",false,false);
			
?>

