<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
if($_GET["consulta"]=="cep") {
	if($_GET["cep"]=="") {
		echo '<script>alert("Digite o CEP para efetuar a consulta!");
			document.form1.cep.focus();
			</script>';	
	}
	else {
		$cep =  $_GET['cep'];
		$sql = "SELECT * FROM cep WHERE CEP = $cep";
		$mysql_query = $_concomum->query($sql);
		if ($mysql_query->num_rows<1) {
			echo '<script>alert("CEP não encontrado!");	
			document.form1.cep.focus();
			</script>';					
		}else {
			while ($dados_cep = $mysql_query->fetch_assoc()) {
				$controlaArray = 0;	
				echo "<script>";
				echo 'document.form1.cep.value="'.$dados_cep['CEP'].'";';
				echo 'document.form1.tipologia.value="'.$dados_cep['TIPOLOG'].'";';
				echo 'document.form1.tipologia.value=document.form1.tipologia.value.toUpperCase();';
				echo 'document.form1.rua.value="'.$dados_cep['RUA'].'";';
				echo 'document.form1.rua.value=document.form1.rua.value.toUpperCase();';
				echo 'document.form1.numeracao.value="'.$dados_cep["NUMERACAO"].'";';
				echo 'document.form1.bairro.value="'.$dados_cep['BAIRRO1'].'";';
				echo 'document.form1.bairro.value=document.form1.bairro.value.toUpperCase();';
				echo 'document.form1.bairro2.value="'.$dados_cep['BAIRRO2'].'";';
				echo 'document.form1.bairro2.value=document.form1.bairro2.value.toUpperCase();';
				echo 'document.form1.cidade.value="'.$dados_cep['CIDADE'].'";';
				echo 'document.form1.cidade.value=document.form1.cidade.value.toUpperCase();';
				echo 'document.form1.uf.value="'.$dados_cep['UF'].'";';
				echo 'document.form1.uf.value=document.form1.uf.value.toUpperCase();';
				echo 'document.form1.reg.value="'.$dados_cep['REG'].'";';
				if ($dados_cep['DTCAD']==NULL){
					echo 'document.getElementById("dtcad").innerHTML ="";';
				}else{
					echo 'document.getElementById("dtcad").innerHTML ="'.FormatDateTime( $dados_cep['DTCAD'],7).'";';
				}
				echo 'document.getElementById("respcad").innerHTML="'.$dados_cep['RESPCAD'].'";';
				echo "</script>";
			}
		}
	}
}else if($_GET["consulta"]=="rua") {
	if($_GET["rua"]=="") {
		echo '<script>alert("Digite a Rua para efetuar a consulta!");
		document.form1.textfield.focus();
			</script>';	
	}
	else {
		$sql = "SELECT * FROM cep WHERE RUA='".$_GET['rua']."' and CIDADE = '".$_GET['cidade']."'";
		$mysql_query = $_concomum->query($sql);
		if ($mysql_query->num_rows<1) {
			echo '<script>alert("CEP n\u00e3o encontrado!");	
			document.form1.cep.focus();
			</script>';					
		}else {
			while ($dados_cep = $mysql_query->fetch_assoc()) {
				$controlaArray = 0;	
				echo "<script>";
				echo 'document.form1.cep.value="'.$dados_cep['CEP'].'";';
				echo 'document.form1.tipologia.value="'.$dados_cep['TIPOLOG'].'";';
				echo 'document.form1.tipologia.value=document.form1.tipologia.value.toUpperCase();';
				echo 'document.form1.rua.value="'.$dados_cep['RUA'].'";';
				echo 'document.form1.rua.value=document.form1.rua.value.toUpperCase();';
				echo 'document.form1.numeracao.value="'.$dados_cep["NUMERACAO"].'";';
				echo 'document.form1.bairro.value="'.$dados_cep['BAIRRO1'].'";';
				echo 'document.form1.bairro.value=document.form1.bairro.value.toUpperCase();';
				echo 'document.form1.bairro2.value="'.$dados_cep['BAIRRO2'].'";';
				echo 'document.form1.bairro2.value=document.form1.bairro2.value.toUpperCase();';
				echo 'document.form1.cidade.value="'.$dados_cep['CIDADE'].'";';
				echo 'document.form1.cidade.value=document.form1.cidade.value.toUpperCase();';
				echo 'document.form1.uf.value="'.$dados_cep['UF'].'";';
				echo 'document.form1.uf.value=document.form1.uf.value.toUpperCase();';
				echo 'document.form1.reg.value="'.$dados_cep['REG'].'";';				
				if ($dados_cep['DTCAD']==NULL){
					echo 'document.getElementById("dtcad").innerHTML ="";';
				}else{
					echo 'document.getElementById("dtcad").innerHTML ="'.FormatDateTime( $dados_cep['DTCAD'],7).'";';
				}
				echo 'document.getElementById("respcad").innerHTML="'.$dados_cep['RESPCAD'].'";';
				echo "</script>";
			}
		}
	}
}
?>