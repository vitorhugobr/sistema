<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina

$_sql = "SELECT * from users WHERE usuario = ".$_GET['user'];
$statement = $pdo->prepare($_sql);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
  // Definimos a mensagem de sucesso
	echo '<script>document.form1.txtUser.focus();alert("Usu&aacute;riio n&atilde;o cadastrado!");	
	document.form1.btnIncUser.disabled=false;
	document.getElementById("cablibera").innerHTML ="";
	</script>';					
}else{
	$_SESSION['message'] = '';
  	// Definimos a mensagem de erro
	echo '<script>	
	document.form1.txtNome.disabled=true;
	document.form1.btnGravUser.disabled=true;
	document.form1.btnCanc.disabled=false;
	document.form1.btnExcUser.disabled=true;
	document.form1.btnExcluir.disabled=false;
	document.form1.btnIncLib.disabled=false;
	document.form1.btnGravLib.disabled=true;
	document.form1.btnIncUser.disabled=false;
	document.getElementById("cablibera").innerHTML ="";
	</script>';					
}
$_con->close;	
?>