<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina

/*echo '<script>alert("'.$_GET['prg'].'");</script>';	
*/
$prog = $_GET['prg'];
$usuario = $_GET['user'];
$query = "SELECT * from users WHERE usuario = '".$usuario."'";
//echo $query;
$mysql_query = $_con->query($query);

if ($mysql_query->num_rows<1) {
  echo '<script>alert("Usuário não encontrado aqui! ");	
		document.form1.txtUser.focus();
		</script>';					
}else{
  while ($dados_s = $mysql_query->fetch_assoc()) {
	$nome = $dados_s['nome'];	
	$codigo = $dados_s["codigo"];
	$usu = $dados_s["usuario"];
	$niv = $dados_s["nivel"];
	if ($prog=='ac') {
	  echo "<script>";
	  echo 'document.form1.txtnome.value= "'.$usu.'";';
	  echo 'document.form1.txtusuario.value ="'. $usu.'";';			
	  echo '</script>';
	}else{
	  echo "<script>";
	  echo 'document.form1.txtnome.value= "'.$usu.'";';
	  echo 'document.form1.txtCodigo.value ="'. $codigo.'";';		
	  echo 'document.form1.txtUser.value ="'. $usu.'";';			
	  echo 'document.form1.txtusuario.value ="'. $usu.'";';			
	  echo 'document.form1.txtNivel.value ="'. $niv.'";';			
	  echo 'document.form1.txtSenha0.value ="";';			
	  echo 'document.form1.txtSenha1.value ="";';			
	  echo 'document.form1.txtSenha0.focus() ="";';			
	  echo '</script>';
	}
  }
}
?>



