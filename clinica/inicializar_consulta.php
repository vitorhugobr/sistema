<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

$cod_cadastro = filter_input(INPUT_GET, 'cod_cadastro',FILTER_DEFAULT);
$id = $_GET["id"];		 
//  echo '<br><br><br>';

$strsql = 'UPDATE agenda_clinica SET ';
$strsql .= "situacao =4";
$strsql .= ' WHERE id='.$id;

//echo  '<br><br><br><br>'.$strsql.'<br>';

$_SESSION['ult_eleitor_pesquisado']=$cod_cadastro;

$resp = executa_sql($strsql,"Consulta iniciada com sucesso","ERRO ao alterar consulta",true,true);

header("Location: ../eleitores/cadastro.php#tela_prontuarios");

?>