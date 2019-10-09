<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$id = filter_input(INPUT_GET, 'id',FILTER_DEFAULT);
$remedio = htmlspecialchars(filter_input(INPUT_GET, 'remedio',FILTER_DEFAULT));
$qtde = htmlspecialchars(filter_input(INPUT_GET, 'qtde',FILTER_DEFAULT));
$posologia = htmlspecialchars(filter_input(INPUT_GET, 'posologia',FILTER_DEFAULT));

//
$theValue = (!get_magic_quotes_gpc()) ? addslashes($remedio) : $remedio;
$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
$remedio = strtoupper($theValue);

$theValue = (!get_magic_quotes_gpc()) ? addslashes($qtde) : $qtde;
$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
$qtde = strtoupper($theValue);

$theValue = (!get_magic_quotes_gpc()) ? addslashes($posologia) : $posologia;
$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
$posologia = strtoupper($theValue);

	// altera no banco	
	$strsql = 'UPDATE dados_receita SET ';
	$strsql .= 'medicamento ='.$remedio;
	$strsql .= ', qtde ='.$qtde;
	$strsql .= ', posologia ='.$posologia;
	$strsql .= ' WHERE id='.$id;

//echo $strsql;

gravaoperacoes("receituario","A", $_SESSION["usuarioUser"],"Receituário #: ".$id);	
//echo $sql2." - ".$id_novo;
//header("Location: receituario.php?id=".$id_novo);

	
$ret = executa_sql($strsql,"Remédio alterado com sucesso","ERRO ao alterar Remédio",true,true);

?>