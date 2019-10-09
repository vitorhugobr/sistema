<?php 
// esta função gravará o exame solicitado pelo médico na tabela exames
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$cod_cad_exame = $_GET["cod_exame"];

$id_exame = $_SESSION['id_exame'];

$strsql_item = 'INSERT into exames_itens VALUES(';
$strsql_item .= $id_exame;
$strsql_item .= ",".$cod_cad_exame;
$strsql_item .= ")";
	
//echo $strsql_item."<br>";
	
$ret = executa_sql($strsql_item,"Exame incluído com sucesso","ERRO ao gravar Exame ".$strsql_item,false,false);

?>