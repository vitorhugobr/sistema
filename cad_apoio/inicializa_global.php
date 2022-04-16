<?php 
//include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
session_start();
//protegePagina(); // Chama a função que protege a página

$cod_cadastro = $_GET['cod_cadastro'];

$_SESSION['ult_eleitor_pesquisado']=$cod_cadastro;

header("Location: ../eleitores/cadastro.php");

?>