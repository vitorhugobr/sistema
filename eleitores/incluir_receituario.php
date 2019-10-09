<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
	$_SESSION['tab']= 6;

		
	$id = "NULL";
	$cod_cadastro = $_GET['cod_cadastro'];
	$tp_uso = $_GET['tp_uso'];
	$controlado = $_GET['controlado'];
	$data_receita = $_GET['data_receita'];
	// DTNASC
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_receita) : $data_receita;
	$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
	$dtnadata_receitasc = $theValue;
	//
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($medicacao) : $medicacao;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$medicacao = $theValue;
	
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($controlado) : $controlado;
	$theValue = ($theValue != "") ? intval($theValue) : "NULL";
	$controlado = $theValue;
	// altera no banco
	
	$strsql = 'INSERT into receituario VALUES(';
	$strsql .= $id;
	$strsql .= ",".$cod_cadastro;
	$strsql .= ",".$data_receita;
	$strsql .= ",".$tp_uso;
	$strsql .= ",".$controlado;
	$strsql .= ')';
	
	//echo $strsql;
	
	gravaoperacoes("receituario","I", $_SESSION["usuarioUser"],"Receituário #: ".$id);
	
	$ret = executa_sql($strsql,"Receituário gravado com sucesso","ERRO ao gravar Receituário",true,true);

?>