<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

$id = $_GET['id'];
$data_consulta = $_GET['data_consulta'];

// inclusão
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_consulta) : $data_consulta;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$data_consulta = $theValue;

$strsql = 'UPDATE espera SET ';
$strsql .= "data_consulta =".$data_consulta;
$strsql .= ' WHERE id='.$id;

//echo "<br>".$strsql."<br>";

gravaoperacoes("espera","a", $_SESSION["usuarioUser"],"Alterada da consulta #: ".$id);

executa_sql($strsql,"Lista de espera alterada","Erro ao alterar lista de espera",false,true);
?>
