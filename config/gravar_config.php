<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

//echo '<script>	if (confirm("Confirma a gravação do Prontuário ")){';
		
	$id = htmlspecialchars(filter_input(INPUT_POST, 'id_politico',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($id) : $id;
	$theValue = ($theValue != "") ? intval($theValue) :1;
	$id = $theValue;

	$partido = htmlspecialchars(filter_input(INPUT_POST, 'partido',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($partido) : $partido;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$partido = $theValue;

	$politico = htmlspecialchars(filter_input(INPUT_POST, 'politico',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($politico) : $politico;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$politico = $theValue;

	$end_pol = htmlspecialchars(filter_input(INPUT_POST, 'endereco',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($end_pol) : $end_pol;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$end_pol = $theValue;

	$email_pol = htmlspecialchars(filter_input(INPUT_POST, 'email',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($email_pol) : $email_pol;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$email_pol = $theValue;

	$cidade_pol = htmlspecialchars(filter_input(INPUT_POST, 'cidade',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($cidade_pol) : $cidade_pol;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$cidade_pol = $theValue;

	$estado_pol = htmlspecialchars(filter_input(INPUT_POST, 'estado',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($estado_pol) : $estado_pol;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$estado_pol = $theValue;

	$cep_pol = htmlspecialchars(filter_input(INPUT_POST, 'cep',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($cep_pol) : $cep_pol;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$cep_pol = $theValue;

	$endurl = htmlspecialchars(filter_input(INPUT_POST, 'endurl',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($endurl) : $endurl;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$endurl = $theValue;

	$endfoto = htmlspecialchars(filter_input(INPUT_POST, 'endfoto',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($endfoto) : $endfoto;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$endfoto = $theValue;

	$ativo = htmlspecialchars(filter_input(INPUT_POST, 'ativo',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($ativo) : $ativo;
	$theValue = ($theValue != "") ? intval($theValue) :1;
	$ativo = $theValue;

	$host_pol = htmlspecialchars(filter_input(INPUT_POST, 'host_pol',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($host_pol) : $host_pol;
	$theValue = ($theValue != '') ? " '" . $theValue . "'" : "NULL";
	$host_pol = $theValue;

	$email_retorno = htmlspecialchars(filter_input(INPUT_POST, 'email_retorno',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($email_retorno) : $email_retorno;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$email_retorno = $theValue;

	$fones_pol = htmlspecialchars(filter_input(INPUT_POST, 'fones_pol',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($fones_pol) : $fones_pol;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$fones_pol = $theValue;

	$versao = htmlspecialchars(filter_input(INPUT_POST, 'versao',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($versao) : $versao;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$versao = $theValue;

	$email2 = htmlspecialchars(filter_input(INPUT_POST, 'email2',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($email2) : $email2;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$email2 = $theValue;

	$nome2 = htmlspecialchars(filter_input(INPUT_POST, 'nome2',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome2) : $nome2;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$nome2 = $theValue;

	$email3 = htmlspecialchars(filter_input(INPUT_POST, 'email3',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($email3) : $email3;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$email3 = $theValue;

	$nome3 = htmlspecialchars(filter_input(INPUT_POST, 'nome3',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome3) : $nome3;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$nome3 = $theValue;

	$email4 = htmlspecialchars(filter_input(INPUT_POST, 'email4',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($email4) : $email4;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$email4 = $theValue;

	$nome4 = htmlspecialchars(filter_input(INPUT_POST, 'nome4',FILTER_DEFAULT));
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome4) : $nome4;
	$theValue = ($theValue != '') ? ' "' . $theValue . '"' : "NULL";
	$nome4 = $theValue;

	// altera no banco
	
	$strsql = 'UPDATE config SET ';
	$strsql .= 'politico ='.$politico;
	$strsql .= ', end_pol ='.$end_pol;
	$strsql .= ', email_pol ='.$email_pol;
	$strsql .= ', cidade_pol ='.$cidade_pol;
	$strsql .= ', estado_pol ='.$estado_pol;
	$strsql .= ', cep_pol ='.$cep_pol;
	$strsql .= ', endurl ='.$endurl;
	$strsql .= ', endfoto ='.$endfoto;
	$strsql .= ', ativo ='.$ativo;
	$strsql .= ', host_pol ='.$host_pol;
	$strsql .= ', email_retorno ='.$email_retorno;
	$strsql .= ', fones_pol ='.$fones_pol;
	$strsql .= ', versao ='.$versao;
	$strsql .= ', partido ='.$partido;
	$strsql .= ', email2 ='.$email2;
	$strsql .= ', nome2 ='.$nome2;
	$strsql .= ', email3 ='.$email3;
	$strsql .= ', nome3 ='.$nome3;
	$strsql .= ', email4 ='.$email4;
	$strsql .= ', nome4 ='.$nome4;
	$strsql .= ' WHERE id='.$id;
	
	#echo $strsql;
	
	$ret = executa_sql_comum($strsql,"Configuração gravada com sucesso","ERRO ao gravar configuração",true,false);
	
  	header("Location: config.php");

?>