<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

if($_GET["cep"]=="") {
  echo '<script>alert("Digite o CEP para efetuar a consulta!");
  document.form1.txtcep.focus();
  </script>';	
}
else {
  $cep = $_GET['cep'];
  $query = "SELECT * FROM cep WHERE CEP = $cep";
  #$mysql_query = mysql_query($query);
  $mysql_query = $_concomum->query($query);
  if ($mysql_query->num_rows<1) {
	  echo '<script>alert("CEP não encontrado!");	
	  document.form1.txtcep.focus();
	  </script>';					
  }else {
      while ($dados_cep = $mysql_query->fetch_assoc()) {
	  #while ($dados_cep = mysql_fetch_array($mysql_query)) {
		  $controlaArray = 0;	
		  echo "<script>";
		  echo 'document.form1.txtCep.value="'.$dados_cep['CEP'].'";';
		  echo 'document.form1.txtTipologia.value="'.$dados_cep['TIPOLOG'].'";';
		  echo 'document.form1.txtTipologia.value=document.form1.txtTipologia.value.toUpperCase();';
		  echo 'document.form1.txtLogradouro.value="'.$dados_cep['RUA'].'";';
		  echo 'document.form1.txtLogradouro.value=document.form1.txtLogradouro.value.toUpperCase();';
		  echo 'document.form1.txtBairro.value="'.$dados_cep['BAIRRO1'].'";';
		  echo 'document.form1.txtBairro.value=document.form1.txtBairro.value.toUpperCase();';
		  echo 'document.form1.txtCidade.value="'.$dados_cep['CIDADE'].'";';
		  echo 'document.form1.txtCidade.value=document.form1.txtCidade.value.toUpperCase();';
		  echo 'document.form1.txtUf.value="'.$dados_cep['UF'].'";';
		  echo 'document.form1.txtUf.value=document.form1.txtUf.value.toUpperCase();';
		  echo 'document.form1.txtNumero.focus();';
		  echo "</script>";
	  }
  }
}
?>