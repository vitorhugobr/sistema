<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
if($_GET["codigo"]=="") {
	echo '<script>alert("Digite o CEP para efetuar a consulta!");
	document.form1.cep.focus();
		</script>';	
}else {
	$cep = $_GET['codigo'];
	$query = "SELECT * FROM cep WHERE cep= $cep";
	$mysql_query = $_concomum->query($query);
	if ($mysql_query->num_rows==0) {
		echo '<script>alert("CEP não encontrado!");	
		document.form1.cep.focus();
		</script>';					
	}else {
		while ($dados_cep = $mysql_query->fetch_assoc()) {
			$controlaArray = 0;	
			echo "<script>";
			echo 'document.form1.cep.value="'.$dados_cep['CEP'].'";';
			echo 'document.form1.tipolog.value="'.$dados_cep['TIPOLOG'].'";';
			echo 'document.form1.rua.value="'.$dados_cep['RUA'].'";';
			echo 'document.form1.bairro.value="'.$dados_cep['BAIRRO1'].'";';
			echo 'document.form1.cidade.value="'.$dados_cep['CIDADE'].'";';
			echo 'document.form1.uf.value="'.$dados_cep['UF'].'";';
			echo 'document.form1.reg.value="'.$dados_cep['REG'].'";';
			echo 'document.form1.numero.focus();';
			echo "</script>";
		}
	}
}
?>