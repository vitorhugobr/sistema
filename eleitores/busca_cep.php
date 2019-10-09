<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
if($_GET["codigo"]=="") {
	echo '<script>alert("Digite o CEP para efetuar a consulta!");
	document.alteracadastro.cep.focus();
		</script>';	
}else {
	$cep = $_GET['codigo'];
	$query = "SELECT * FROM cep WHERE cep= $cep";
	$mysql_query = $_concomum->query($query);
	if ($mysql_query->num_rows==0) {
		echo '<script>alert("CEP não encontrado!");	
		document.alteracadastro.cep.focus();
		</script>';					
	}else {
		while ($dados_cep = $mysql_query->fetch_assoc()) {
			$controlaArray = 0;	
			echo "<script>";
			echo 'document.alteracadastro.cep.value="'.$dados_cep['CEP'].'";';
			echo 'document.alteracadastro.tipolog.value="'.$dados_cep['TIPOLOG'].'";';
			echo 'document.alteracadastro.tipolog.value=document.alteracadastro.tipolog.value.toUpperCase();';
			echo 'document.alteracadastro.rua.value="'.$dados_cep['RUA'].'";';
			echo 'document.alteracadastro.rua.value=document.alteracadastro.rua.value.toUpperCase();';
			echo 'document.alteracadastro.bairro.value="'.$dados_cep['BAIRRO1'].'";';
			echo 'document.alteracadastro.bairro.value=document.alteracadastro.bairro.value.toUpperCase();';
			echo 'document.alteracadastro.cidade.value="'.$dados_cep['CIDADE'].'";';
			echo 'document.alteracadastro.uf.value="'.$dados_cep['UF'].'";';
			echo 'document.alteracadastro.cidade.value=document.alteracadastro.cidade.value.toUpperCase();';
			echo 'document.alteracadastro.reg.value="'.$dados_cep['REG'].'";';
			echo 'document.alteracadastro.numero.focus();';
			echo "</script>";
		}
	}
}
?>