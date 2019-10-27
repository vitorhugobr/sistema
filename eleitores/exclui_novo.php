<?php 

include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina();
include("../utilitarios/funcoes.php");

$codigo = $_GET["cod"];

$strsql2 = "DELETE from cadastro where cadastro.CODIGO = ".$codigo;

executa_sql($strsql2,"Inclusão cancelada pelo usuário","Cadastro NÃO excluído!",true,true);
//	
$_SESSION['ult_eleitor_pesquisado']=0;

?>