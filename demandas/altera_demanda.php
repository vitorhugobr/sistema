<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
	$numero = $_GET["numero"];
	$protocolo = $_GET["protocolo"];
	$assunto = strtoupper($_GET["assunto"]);
	$codigo = $_GET["codigo"];
	$endereco = strtoupper($_GET["endereco"]);
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($endereco) : $endereco;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$endereco = $theValue;
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($assunto) : $assunto;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$assunto = $theValue;
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($protocolo) : $protocolo;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$protocolo = $theValue;
	$descricao = strtoupper($_GET["descricao"]);
	$descricao = strtr($descricao,"#/","  ");
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($descricao) : $descricao;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$descricao = $theValue;

	date_default_timezone_set('America/Sao_Paulo');
	$strsql = 'UPDATE encaminhamentos SET ';
	$strsql .= "codigo =".$codigo;
	$strsql .= ",assunto =".$assunto;
	$strsql .= ",protocolo =".$protocolo;
	$strsql .= ",descricao =".$descricao;
	$strsql .= ",endereco =".$endereco;
	$strsql .= ' WHERE numero ='.$numero;
	//echo $strsql;
	$retorno =  executa_sql($strsql,"Demanda alterada com sucesso","Demanda não alterada ".$strsql,true,true);	

?>
