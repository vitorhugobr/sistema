<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

//echo '<script>	if (confirm("Confirma a gravação do Prontuário ")){';
	$_SESSION['tab']=5;
	
	$id = htmlspecialchars(filter_input(INPUT_POST, 'id_prontuario',FILTER_DEFAULT));
	$diag = htmlspecialchars(filter_input(INPUT_POST, 'diagnostic',FILTER_DEFAULT));
	//
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($diag) : $diag;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$diag = $theValue;
	
	// altera no banco
	
	$strsql = 'UPDATE prontuario SET ';
	$strsql .= 'diagnostico ='.$diag;
	$strsql .= ' WHERE id='.$id;
	
	//echo $strsql;
	
	gravaoperacoes("prontuario","A", $_SESSION["usuarioUser"],"Prontuario #: ".$id);
//echo '}</script>';
	
	$ret = executa_sql($strsql,"Prontuário gravado com sucesso","ERRO ao gravar prontuário",true,false);

echo "<script>document.location='cadastro.php#tela_prontuarios';</script>";

?>