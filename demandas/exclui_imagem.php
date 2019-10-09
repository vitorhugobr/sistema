<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
	$arq = $_GET["arq"];
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($arq) : $arq;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$arq = $theValue;
	// UNLINK é usado para excluir um arquivo com php. retorna 1 se OK ou ) se não
	
	//echo $arq;
//	debug();
	if (unlink($arq)){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Exclusão da Imagem com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";					
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Imagem não Excluída! FUNÇÃO AINDA EM DESENVOLVIMENTO<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";					
	}
	echo '<script>window.location.reload();</script>'; 
?>
