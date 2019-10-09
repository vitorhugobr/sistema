<?php 
// esta função gravará o exame solicitado pelo médico na tabela exames
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$cod_exame = $_GET['cod_exame'];
$id_exame = $_GET['id_exame'];

$strsql = "delete from `exames_itens` where id_exame = ".$id_exame." and cod_exame = ".$cod_exame;
	
//echo "<br><br><br><br>".$strsql."<br>";
	
$ret = executa_sql($strsql,"Item do Exame excluído com sucesso","ERRO ao gravar Exame ".$strsql,true,true);

?>