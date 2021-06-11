<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina

/*echo '<script>alert("'.$_GET['user'].'");</script>';	*/

$_sql = "SELECT * FROM users WHERE usuario = '".$_GET['usuario']."'";
$statement = $pdo->prepare($_sql);
$statement->execute();
$total = $statement->rowCount();
if($total==0){
  // Definimos a mensagem de sucesso
	  echo '<script>alert("Usuário não cadastrado!\nTente novamente");document.form1.txtusuario.focus();';
	  echo 'document.form1.txtcodigo.value ="";';		
	  echo 'document.form1.txtusuario.value ="";';			
	  echo 'document.form1.txtnivel.value ="";';			
	  echo 'document.form1.txtnome.value ="";';		
	  echo 'document.form1.txtsenha.value ="";';		
	  echo 'document.form1.txtconfirma.value ="";';		
	  echo 'document.form1.txtemail.value ="";';		
	  echo '</script>';					
}else{
	$_SESSION['message'] = '';
  	// Definimos a mensagem de erro
  	while($_row = $statement->fetch()) {	
		$codigo = $_row["codigo"];
		$_SESSION['codigo'] = $codigo;
		$usu = $_row["usuario"];
		$niv = $_row["nivel"];
		$nome = $_row["nome"];
		$email = $_row["email"];
		$arquivo = "../imagens/fotos/users/".$codigo.".jpg";
		if (file_exists($arquivo)) {
			$imagem = $arquivo;	
		} else {
			$imagem = "../imagens/fotos/users/usuario.png";	
		}		
		?>
		<script>
		document.form1.txtcodigo.value = '<?php echo $codigo ?>';
		document.form1.txtusuario.value = '<?php echo $usu ?>';
		//document.getElementById("txtusuario").disabled = false;
		document.form1.txtnivel.value = '<?php echo $niv ?>';			
		//document.getElementById("txtnivel").disabled = false;
		document.form1.txtnome.value = '<?php echo $nome ?>';		
		//document.getElementById("txtnome").disabled = false;
		document.form1.txtemail.value = '<?php echo $email ?>';		
		//document.getElementById("txtemail").disabled = false;
		document.getElementById("imgfoto").src = '<?php echo $imagem ?>';
		document.getElementById("btnnovo").style.display = "none";;
		document.getElementById("btngrava").style.display = "block";
		document.getElementById("btnexclui").disabled = "block";
        //document.getElementById("btncancela").style.display="block";
		document.form1.txtnivel.focus();
		</script>
		<?php
	}				
}
?>

