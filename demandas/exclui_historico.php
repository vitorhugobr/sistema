<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
  $id = $_GET["id"];
	$strsql = "DELETE from `historico_encaminhamentos` WHERE id=".$id;
//	echo $strsql;
	gravaoperacoes("historico_encaminhamentos","E", $_SESSION["usuarioUser"],"Excluída Resposta #: ".$id);

	$retorno =  executa_sql($strsql,"Resposta excluída com sucesso","Resposta não excluída",true,true);	
?>
