<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$clinica = $_GET["clinica"];		 
$data_agenda = $_GET['data_agenda'];
//  echo '<br><br><br>';
$dia_agenda = substr($data_agenda,0,2);
//echo $dia_agenda.'<br>';
$mes_agenda = substr($data_agenda,3,2);
//echo $mes_agenda.'<br>';
$ano_agenda = substr($data_agenda,6,4);
//echo $ano_agenda.'<br>';
$data_agenda = $ano_agenda."-".$mes_agenda."-".$dia_agenda;

// A seguir vai verificar se alguém da agenda faltou a consulta e gravará no prontuário!

  $query = "SELECT * from agenda_dia_clinica WHERE clinica = ".$clinica." and data_agenda='".$data_agenda."' and situacao < 3";
  //echo $query.'<br>';
  $mysql_query = $_con->query($query);
  $qtderegs = $mysql_query->num_rows;
  if ($qtderegs>0) {
	while ($dado = $mysql_query->fetch_assoc()) {
		$id = $dado['id'];
		$cod_cadastro = $dado['cod_cadastro']; 
		$fones = $dado['fones']; 
		$nome = $dado['nome']; 
		$situacao = $dado['situacao']; 
		$prioridade = $dado['prioridade']; 
		$observacoes = $dado['observacoes']; 
		$status = $dado['status'];
		// colocar situação da consulta como FALTA, pois a situação é igual 1-pendente ou 2-faltou 
		$strsql = "UPDATE `agenda_clinica` SET `situacao` = '2' WHERE `agenda_clinica`.`id` = ".$id;
		//echo  '<br>'.$strsql1.'<br>';
		$resp1 = executa_sql($strsql1,"Situação alterada com sucesso","ERRO ao alterar situação",false,false);
		// gravar no prontuário a falta na consulta
		$query_inc_prontuario = "INSERT INTO prontuario VALUES(";
		$query_inc_prontuario .= "NULL";
		$query_inc_prontuario .= ",".$cod_cadastro;
		$query_inc_prontuario .= ",'".$data_agenda;
		$query_inc_prontuario .= "', 'NÃO COMPARECEU NESTA DATA'";
		$query_inc_prontuario .= ",".$clinica;
		$query_inc_prontuario .= ",".$prioridade;
		$query_inc_prontuario .= ")";
		//echo $query_inc_prontuario."<br>";
		$resp2 = executa_sql($query_inc_prontuario,"OK","ERRO",false,false);
	}
}

// altera no banco. Comando será executado no final

$strsql = 'UPDATE agenda_clinica SET ';
$strsql .= "status =1";
$strsql .= " WHERE data_agenda='".$data_agenda."' and clinica =".$clinica;

//echo  '<br><br><br><br>'.$strsql.'<br>';
gravaoperacoes("agenda_clinica","A", $_SESSION["usuarioUser"],"Agenda do dia: ".$data_agenda." encerrada");

$resp = executa_sql($strsql,"Agenda do dia: ".FormatDateTime($data_agenda,7)." encerrada com sucesso","ERRO ao enc errar Espera",true,true);


?>