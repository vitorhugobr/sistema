<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");
$cod   = $_GET['cod'];

$usuario = $_GET['usuario'];

$strsql2 = "Delete from liberacao where username = '".$usuario."'";
//echo $strsql2;
$statement2 = $pdo->prepare($strsql2);

$statement2->execute();

$total2 = $statement2->rowCount();

if (!$statement2){	
  // Definimos a mensagem de sucesso
	echo '<script>';
	echo 'alert("ERRO EXCLUSÃO das liberações: Usuário '.$usuario;						
	echo '</script>';
}else{
	$strsql = "Delete from users where codigo = ".$cod;
	/*echo '<script>alert("'.$strsql.'");</script>';
	*/
	executa_sql($strsql,"Usuário excluído com sucesso!","ERRO ao excluir: Usuário",true,true);
	gravaoperacoes("users","E",$_SESSION["usuarioUser"],"Excluído usuário ".$usuario);

}
$_con->commit();
$_con->close();
?>