<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina

/*echo '<script>alert("'.$_GET['prg'].'");</script>';	
*/

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
	$usu = $dados_s['usuario'];	
	$codigo = $dados_s["codigo"];
	echo "<script>";
	echo 'document.form1.txtcodigo.value= "'.$codigo.'";';
	echo 'document.form1.txtusuario.value ="'. $usu.'";';			
	echo 'document.getElementById("sendfoto").disabled = false;';
	echo 'document.getElementById("foto").disabled = false;';
	echo '</script>';
  }
}
?>



