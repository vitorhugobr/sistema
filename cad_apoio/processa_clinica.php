<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");

	$id = htmlspecialchars(filter_input(INPUT_POST, 'id_clinica',FILTER_DEFAULT));
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

	$strsql = 'UPDATE clinicas SET ';
	$strsql .= "clinica =".$nome_clinica;
	$strsql .= ",endereco = ".$endereco;
	$strsql .= ",telefone = ".$telefone;
	$strsql .= " WHERE id=".$id;
	
//	echo $strsql;
	gravaoperacoes("clinicas","A", $_SESSION["usuarioUser"],"clinica #: ".$id);
 	
 	$ret = executa_sql($strsql,"Clínica alterada com sucesso","ERRO ao gravar Clínica",true,false);
	
  header("Location: clinicas.php");
 ?>
