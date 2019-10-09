<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$descricao = $_GET['desc'];
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;
gravaoperacoes("campanha","I", $_SESSION["usuarioUser"],"Campanha incluída #: ".$codigo);

$_sql = "Insert into campanha values(NULL,".$descricao.")";

$resp = executa_sql($_sql,"Campanha incluída com sucesso","Campanha NÃO incluída",true, true);

$sql = 'SELECT MAX(CODIGO) AS codigo FROM campanha';

$mysql_query = $_con->query($sql);

if ($mysql_query->num_rows<1) {
	echo '<script>alert("ERRO ao ler campanha!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s['codigo'].'";';
	}
}

		
?>