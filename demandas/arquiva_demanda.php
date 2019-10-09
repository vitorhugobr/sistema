<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");	

$numero = $_GET['numero'];

$id = "NULL";

$usuarioresp = $_SESSION["usuarioUser"];

date_default_timezone_set('America/Sao_Paulo');

// insere no banco uma resposta na demanda como encerrada nesta data para identificar data e quem encerrou
$strsql = "INSERT INTO `historico_encaminhamentos` VALUES (NULL,";
$strsql .= $numero.",'".date("Y-m-d H:i:s")."','ARQUIVADA NESTA DATA','".$usuarioresp."'";
$strsql .= ")";

$retorno2 = executa_sql($strsql,"Resposta incluída com sucesso","Resposta NÃO incluída",false,false); 

$_sql = "Update encaminhamentos set situacao = 5 where numero = ".$numero;
//echo $_sql."<br>";

gravaoperacoes("demandas","A", $_SESSION["usuarioUser"],"arquivou demanda #: ".$numero);

$resp = executa_sql($_sql,"Demanda Arquivada!","Demanda NÃO Arquivada!",true,true);


?>

