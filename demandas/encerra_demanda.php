<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	

$numero = $_GET['numero'];
//echo $numero;

$id = "NULL";
//echo $tarefa;

$usuarioresp = $_SESSION["usuarioUser"];

date_default_timezone_set('America/Sao_Paulo');

// insere no banco uma resposta na demanda como encerrada nesta data para identificar data e quem encerrou
$strsql = "INSERT INTO `historico_encaminhamentos` VALUES (NULL,";
$strsql .= $numero.",'".date("Y-m-d H:i:s")."','ENCERRADA NESTA DATA','".$usuarioresp."'";
$strsql .= ")";

$retorno2 = executa_sql($strsql,"Resposta incluída com sucesso","Resposta NÃO incluída",false,false); 

$_sql = "Update encaminhamentos set situacao = 2 where numero = ".$numero;
//echo $_sql."<br>";

gravaoperacoes("demandas","A", $_SESSION["usuarioUser"],"encerrou demanda #: ".$numero);

$resp = executa_sql($_sql,"Demanda Encerrada!","Demanda NÃO encerrada!",true,true);

$strsql = 'UPDATE tarefas SET ';
$strsql .= "data_fim ='".date("Y-m-d H:i:s")."'";
$strsql .= ", status =1";
$strsql .= ' WHERE demanda='.$numero;

//echo $strsql."<br>";

$_res = executa_sql($strsql,"","",false,false);

//$strsql3 = "INSERT INTO historico_tarefas values(NULL,".$tarefa.",'".date("Y-m-d H:i:s")."','Finalizada')";
//echo $strsql3."<br>";

//$_res3 = executa_sql($strsql3,"Tarefa encerrada com sucesso","Tarefa NÃO encerrada",false,false);


?>

