<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$descricao = $_GET['desc'];
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Insert into origem values(NULL,".$descricao.")";

$resp = executa_sql($_sql,"Origem incluída com sucesso","Origem NÃO incluída",true, true);
		
$sql = 'SELECT MAX(Origem) AS codigo FROM origem';
$mysql_query = $_con->query($sql);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("ERRO ao ler origem!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s['codigo'].'";';
		gravaoperacoes("grupos","I", $_SESSION["usuarioUser"],"Grupo incluído #: ".$codigo);	}
}

?>