<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$descricao = $_GET['descricao'];
$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$descricao = $theValue;

$_sql = "Insert into cadastro_exames values(NULL,".$descricao.")";
		
gravaoperacoes("exames","I", $_SESSION["usuarioUser"],"Exame incluído");

$resp = executa_sql($_sql,"Exame incluído com sucesso","Exame NÃO incluído",true, true);

?>