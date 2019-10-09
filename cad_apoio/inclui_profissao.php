<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$descricao = $_GET['desc'];
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

gravaoperacoes("profissao","I", $_SESSION["usuarioUser"],"Profissão incluída #: ".$codigo);

$_sql = "Insert into profissao values(NULL,".$descricao.")";

$resp = executa_sql_comum($_sql,"Profissão incluída com sucesso","Profissão NÃO incluída",true, true);
		
$sql = 'SELECT MAX(Profissao) AS codigo FROM profissao';
$mysql_query = $_concomum->query($sql);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("ERRO ao ler arquivo!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s['codigo'].'";';
	}
}

?>