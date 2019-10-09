<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
$cod_cadastro = $_GET['cod_cadastro'];

$query = "SELECT * from cadastro WHERE cadastro.CODIGO = $cod_cadastro";
$mysql_query = $_con->query($query);
$qtderegs = $mysql_query->num_rows;
if ($qtderegs==0) {
	echo '<script>document.form1.txtFones.focus();</script>';					
}else{

	while ($dados_s = $mysql_query->fetch_assoc()) {
	  	$fone = $dados_s["FONE_CEL"]; 	  	
		$fone2 = $dados_s["FONE_RES"];
		$fone3 = $dados_s["FONE_COM"]; 
		$fones = $fone." ".$fone2." ".$fone3;
		//echo '<br><br><br><br>Telefone: '.$query;		
		echo '<script>';
		echo 'document.form1.txtFones.value = "'.$fones.'";';
		echo 'document.form1.txtFones.focus();</script>';		
	}
}

?>