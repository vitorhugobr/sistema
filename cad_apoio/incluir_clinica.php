<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

	$id = "NULL";
	$endereco = htmlspecialchars(filter_input(INPUT_POST, 'endereco',FILTER_DEFAULT));
	$telefone = htmlspecialchars(filter_input(INPUT_POST, 'telefone',FILTER_DEFAULT));
	$nome_clinica = htmlspecialchars(filter_input(INPUT_POST, 'clinica',FILTER_DEFAULT));
		
	//
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($endereco) : $endereco;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$endereco = $theValue;
	
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($telefone) : $telefone;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$telefone= $theValue;
	
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome_clinica) : $nome_clinica;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$nome_clinica = $theValue;
	
	// altera no banco
	
	$strsql = 'INSERT into clinicas VALUES(';
	$strsql .= $id;
	$strsql .= ",".$nome_clinica;
	$strsql .= ",".$endereco;
	$strsql .= ",".$telefone;
	$strsql .= ')';
	
	gravaoperacoes("receituario","I", $_SESSION["usuarioUser"],"medicamento #: ".$id);

//	echo $strsql;
	
 	$ret = executa_sql($strsql,"Clínica adicionada com sucesso","ERRO ao gravar Clínica",true,false);
	

  header("Location: clinicas.php?");
 
?>