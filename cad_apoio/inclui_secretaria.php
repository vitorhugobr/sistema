<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$descricao = $_GET['desc'];
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;


$_sql = "Insert into secretarias values(NULL,".$descricao.")";

$resp = executa_sql($_sql,"Ssecretaria incluída com sucesso","Secretaria NÃO incluída",true, true);

$sql = 'SELECT MAX(CODIGO) AS codigo FROM secretarias';

$mysql_query = $_con->query($sql);

if ($mysql_query->num_rows<1) {
	echo '<script>alert("ERRO ao ler Secretaria!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s['codigo'].'";';
		gravaoperacoes("Secretaria","I", $_SESSION["usuarioUser"],"Secretaria incluída #: ".$codigo);	}
}

		
?>