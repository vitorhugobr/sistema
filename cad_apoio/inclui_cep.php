<?php 
	include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
	protegePagina(); // Chama a função que protege a página
	include_once('../utilitarios/funcoes.php');
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
	$fieldList["`CEP`"] = $theValue;

	// TIPOLOG
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($tipolog) : $tipolog;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`TIPOLOG`"] = $theValue;

	// SEXO
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($rua) : $rua;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`RUA`"] = $theValue;

	// NUMERACAO
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($numeracao) : $numeracao;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`NUMERACAO`"] = $theValue;

	// BAIRRO1
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($bairro1) : $bairro1;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`BAIRRO1`"] = $theValue;

	// BAIRRO2
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($bairro2) : $bairro2;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`BAIRRO2`"] = $theValue;

	// CIDADE
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($cidade) : $cidade;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`CIDADE`"] = $theValue;

	// UF
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($uf) : $uf;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`UF`"] = $theValue;

	// DTCAD
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtcad) : $dtcad;
	$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
	$fieldList["`DTCAD`"] = $theValue;

	// RESPCAD
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($respcad) : $respcad;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`RESPCAD`"] = $theValue;


	// REG
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($reg) : $reg;
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`REG`"] = $theValue;


	// insere no banco
	$strsql = "INSERT INTO `cep` (";
	$strsql .= implode(",", array_keys($fieldList));
	$strsql .= ") VALUES (";
	$strsql .= implode(",", array_values($fieldList));
	$strsql .= ")";

	gravaoperacoes("cep","I", $_SESSION["usuarioUser"],"Incluído cep #: ".$cep);

	$resp = executa_sql_comum($strsql,"Cep inserido com sucesso","Cep NÃO incluído", true, false);


?>
