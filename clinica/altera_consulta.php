<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$id = $_GET["id"];		 
$prioridade = $_GET["prioridade"];
$situacao = $_GET["situacao"];
$fones = $_GET["fones"];
$observacoes = $_GET["observacoes"];

// ID

$theValue = (!get_magic_quotes_gpc()) ? addslashes($id) : $id;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$id = $theValue;

// PRIORIDADE

$theValue = (!get_magic_quotes_gpc()) ? addslashes($prioridade) : $prioridade;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$prioridade = $theValue;

// SITUACAO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($situacao) : $situacao;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$situacao = $theValue;

// FONES

$theValue = (!get_magic_quotes_gpc()) ? addslashes($fones) : $fones;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fones = $theValue;

// OBS

$theValue = (!get_magic_quotes_gpc()) ? addslashes($observacoes) : $observacoes;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$observacoes = $theValue;


// altera no banco

$strsql = 'UPDATE agenda_clinica SET ';
$strsql .= "situacao =".$situacao;
$strsql .= ",prioridade=".$prioridade;
$strsql .= ",fones =".$fones;
$strsql .= ",observacoes =".$observacoes;
$strsql .= ' WHERE id='.$id;

//echo  '<br><br><br><br>'.$strsql.'<br>';

gravaoperacoes("agenda_clinica","A", $_SESSION["usuarioUser"],"Agenda #: ".$id." situação=".$situacao." prioridade=".$prioridade);

$resp = executa_sql($strsql,"Consulta alterada com sucesso","ERRO ao alterar consulta",true,true);

if ($situacao==3){
	$query = "SELECT * from agenda_clinica WHERE id = ".$id;
//	echo $query.'<br>';
	$mysql_query = $_con->query($query);
	$qtderegs = $mysql_query->num_rows;
	if ($qtderegs==0) {
	}else{
	  while ($dado = $mysql_query->fetch_assoc()) {
		  $id = $dado['id'];
		  $cod_cadastro = $dado['cod_cadastro']; 
		  $clinica = $dado['clinica']; 
		  $data_agenda = $dado['data_agenda']; 
		  $prioridade = $dado['prioridade']; 
		  $query_prontuario = "SELECT * from prontuario WHERE cod_cadastro = ".$cod_cadastro." and data_consulta = '".$data_agenda."' and clinica=".$clinica;
//		  echo $query_prontuario.'<br>';
		  $mysql_query = $_con->query($query_prontuario);
		  $qtdepront = $mysql_query->num_rows;
		  if ($qtdepront==0) {
			  $query_inc_prontuario = "INSERT INTO prontuario VALUES(";
			  $query_inc_prontuario .= "NULL";
			  $query_inc_prontuario .= ",".$cod_cadastro;
			  $query_inc_prontuario .= ",'".$data_agenda;
			  $query_inc_prontuario .= "',' '";
			  $query_inc_prontuario .= ",".$clinica;
			  $query_inc_prontuario .= ",".$prioridade;
			  $query_inc_prontuario .= ")";
//			echo $query_inc_prontuario;
		   	  $resp = executa_sql($query_inc_prontuario,"Consulta alterada com sucesso","ERRO ao alterar consulta",false,true);
		  }else{
		  	while ($dados_nulo = $mysql_query->fetch_assoc()) {
		  	}
		  }
	
	  }
	}
}




?>