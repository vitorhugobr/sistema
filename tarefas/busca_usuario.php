<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina

/*echo '<script>alert("'.$_GET['user'].'");</script>';	*/

$_sql = "SELECT * FROM users WHERE codigo = '".$_GET['codigo']."'";
$statement = $pdo->prepare($_sql);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
  // Definimos a mensagem de sucesso
	  echo '<script>alert("Usuário não cadastrado!\nTente novamente");document.form1.txtnomeusuario.focus();';
	  echo 'document.form1.txtemail.value ="";';		
	  echo '</script>';					
}else{
	$_SESSION['message'] = '';
  	// Definimos a mensagem de erro
  	while($_row = $statement->fetch()) {	
		$email = $_row["email"];
		$codigo = $_row["codigo"];
		echo '<script>';
		echo 'document.form1.txtusuario.value ="'. $codigo.'";';		
		echo 'document.form1.txtemail.value ="'. $email.'";';		
		echo "</script>";
	}				
}
?>

