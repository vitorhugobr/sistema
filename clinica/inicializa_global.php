<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

$cod_cadastro = $_GET['cod_cadastro'];
$_SESSION['ult_eleitor_pesquisado']=$cod_cadastro;

?>