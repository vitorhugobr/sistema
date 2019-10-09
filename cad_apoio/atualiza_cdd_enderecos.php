<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
//protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
//

$query = "select * from cdd";
$mysql_query = $_con->query($query);
$tot=0;
while ($dados_s = $mysql_query->fetch_assoc()) {
	$cepi = $dados_s["inicial"];
	$cepf = $dados_s["final"];
	$reg = $dados_s["reg"];
	
	$strsql = 'UPDATE enderecos SET ';
	$strsql .= "reg =".$reg;
	$strsql .= " WHERE cep BETWEEN $cepi AND $cepf";
	
	$regsl = executa_sql($strsql,"","",false,false);
	$tot=$tot+$regsl;
	echo $strsql." - registros ".$regsl."<br>";
	
}
echo "TOTAL -> ".$tot;
?>