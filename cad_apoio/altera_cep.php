<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once('../utilitarios/funcoes.php');

//			busca os valores dos parâmetros

$cep = $_GET["P0"];	
$tipolog = $_GET["P1"];
$rua = $_GET["P2"];
$numeracao = $_GET["P3"];
$bairro1 = $_GET["P4"];		
$bairro2 = $_GET["P5"];
$cidade = $_GET["P6"];
$uf = $_GET["P7"];
$dtcad = date("d/m/Y");
$respcad = $_SESSION['usuarioUser'];		
$reg = $_GET["P10"];

// CEP
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cep) : $cep;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$cep = $theValue;

// TIPOLOG
$theValue = (!get_magic_quotes_gpc()) ? addslashes($tipolog) : $tipolog;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$tipolog = $theValue;

// SEXO
$theValue = (!get_magic_quotes_gpc()) ? addslashes($rua) : $rua;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$rua = $theValue;

// NUMERACAO
$theValue = (!get_magic_quotes_gpc()) ? addslashes($numeracao) : $numeracao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$numeracao = $theValue;

// BAIRRO1
$theValue = (!get_magic_quotes_gpc()) ? addslashes($bairro1) : $bairro1;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$bairro1 = $theValue;

// BAIRRO2
$theValue = (!get_magic_quotes_gpc()) ? addslashes($bairro2) : $bairro2;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$bairro2 = $theValue;

// CIDADE
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cidade) : $cidade;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$cidade = $theValue;

// UF
$theValue = (!get_magic_quotes_gpc()) ? addslashes($uf) : $uf;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$uf = $theValue;

// DTCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtcad) : $dtcad;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$dtcad = $theValue;

// RESPCAD
$theValue = (!get_magic_quotes_gpc()) ? addslashes($respcad) : $respcad;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$respcad = $theValue;

// REG
$theValue = (!get_magic_quotes_gpc()) ? addslashes($reg) : $reg;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$reg = $theValue;

// altera no banco
$strsql = 'UPDATE cep SET ';
$strsql .= "TIPOLOG =".$tipolog;
$strsql .= ",RUA =".$rua;
$strsql .= ",NUMERACAO =".$numeracao;
$strsql .= ",BAIRRO1=".$bairro1;
$strsql .= ",BAIRRO2=".$bairro2;
$strsql .= ",CIDADE=".$cidade;
$strsql .= ",UF=".$uf;
$strsql .= ",DTCAD=".$dtcad;
$strsql .= ",RESPCAD=".$respcad;
$strsql .= ",REG=".$reg;
$strsql .= " WHERE CEP=".$cep;

//echo $strsql;

$resp = executa_sql_comum($strsql,"Cep alterado com sucesso","Cep NÃO alterado", true, true);

?>