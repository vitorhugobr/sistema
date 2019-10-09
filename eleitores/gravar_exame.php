<?php 
// esta função gravará o exame solicitado pelo médico na tabela exames
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
$_SESSION['tab']= 7;

$data_exame = $_GET["data"];
$cod_cadastro = $_GET["cod_cadastro"];

// Data Receita
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_exame) : $data_exame;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$data_exame = $theValue;

//

$id = "NULL";
$strsql = 'INSERT into exames VALUES(';
$strsql .= $id;
$strsql .= ",".$cod_cadastro;
$strsql .= ",".$data_exame;
$strsql .= ")";
	
//echo $strsql."<br>";
	
$sql = 'SELECT MAX(id) AS id FROM exames';
$mysql_query = $_con->query($sql);
if ($mysql_query->num_rows<1) { 
	echo '<script>alert("ERRO ao ler exames!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$id_exame = $dados_s['id'];
	}
}
$_SESSION['id_exame'] = $id_exame;

gravaoperacoes("exames","I", $_SESSION["usuarioUser"],"Incluído exame ".$id_exame." para : ".$cod_cadastro." em ".$data_exame);	

$ret = executa_sql($strsql,"Exame incluído com sucesso","ERRO ao incluir Exame",true,true);


?>