<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$id = htmlspecialchars(filter_input(INPUT_POST, 'id',FILTER_DEFAULT));
$cod_receita = htmlspecialchars(filter_input(INPUT_POST, 'cod_receita',FILTER_DEFAULT));
$medicamento = htmlspecialchars(filter_input(INPUT_POST, 'medicamento',FILTER_DEFAULT));
$qtde = htmlspecialchars(filter_input(INPUT_POST, 'qtde',FILTER_DEFAULT));
$posologia = htmlspecialchars(filter_input(INPUT_POST, 'posologia',FILTER_DEFAULT));
		
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($cod_receita) : $cod_receita;
	$theValue = ($theValue != "") ? intval($theValue) : "NULL";
	$cod_receita = $theValue;

	//
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($medicamento) : $medicamento;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$medicamento = $theValue;
	
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($qtde) : $qtde;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$qtde = $theValue;
	
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($posologia) : $posologia;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$posologia = $theValue;
	
	// altera no banco
	
	$strsql = 'UPDATE dados_receita SET ';
	$strsql .= "medicamento =".$medicamento;
	$strsql .= ",qtde = ".$qtde;
	$strsql .= ",posologia ".$posologia;
	$strsql .= " WHERE id=".$id;
	
//	echo $strsql;
	gravaoperacoes("receituario","A", $_SESSION["usuarioUser"],"medicamento #: ".$id);
  header("Location: receituario.php?id=".$cod_receita);
	
 	$ret = executa_sql($strsql,"Medicamento alterado com sucesso","ERRO ao gravar Recedituário",true,false);
	
 
?>