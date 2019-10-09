<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
$cod_cadastro = $_GET['cod_cadastro'];
$query = "SELECT * from agenda_clinica WHERE cod_cadastro = ".$cod_cadastro." order by data_agenda desc";

$mysql_query = $_con->query($query);
$qtderegs = $mysql_query->num_rows;
$msg = "";
//echo "<br><br><br><br>".$query."<br>".$qtderegs."<br>";
if ($qtderegs>0) {
	while ($dado = $mysql_query->fetch_assoc()) {
		$id = $dado['id'];
	  	$cod_cadastro = $dado['cod_cadastro']; 
	  	$data_agenda = $dado['data_agenda']; 
		$msg .= FormatDateTime($data_agenda,7).'\n';
  	}
	echo '<script>alert("Últimas consultas em\n'.$msg.'");document.form1.txtFones.focus();</script>';					
}else{
	echo '<script>document.form1.txtFones.focus();</script>';					
}


?>