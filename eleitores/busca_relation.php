<?php
include("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
$query = "SELECT * from cadastro WHERE CODIGO = ".$_GET['cod'];
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows==0) {
	echo '<script>alert("Eleitor não encontrado!");	document.form1.txtnomeson.value="";
	document.form1.txtnomeson.focus();
	</script>';					
}else{
	while ($dado_s = $mysql_query->fetch_assoc()) {
		echo "<script>";
		echo 'document.relations.txtson.value = "'.$dado_s['CODIGO'].'";';	
		echo 'document.relations.txtnomeson.value = "'.$dado_s['NOME'].'";';
		echo 'document.relations.txttipo.focus();';
		echo '</script>';
	}		
}
?>



