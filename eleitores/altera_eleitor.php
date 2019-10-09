<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
//debug();
$codigo = $_GET["P0"];		 
$nome = strtoupper($_GET["P1"]);
$sexo = $_GET["P2"];
$dtcad = $_GET["P3"];
$dtnasc = $_GET["P4"];		
$cargo = $_GET["P5"];
$cargo = strtoupper($cargo);
$fone_res = $_GET["P6"];
$fone_cel = $_GET["P7"];
$fone_com = $_GET["P8"];
$cpf = $_GET["P9"];	
$obs = 	strtoupper($_GET["P10"]);
$condicao = $_GET["P11"];
$email = $_GET["P12"];
$email = strtolower($email);
$grupo = $_GET["P13"];		
$origem = $_GET["P14"];		
$profissao = $_GET["P15"];
$zonal = $_GET["P16"];
$seccao = $_GET["P17"];
$pai_mae = $_GET["P18"];
$filiado = $_GET["P19"];
$recebemat = $_GET["P20"];
$respcadastro = $_SESSION["usuarioUser"];
$usuario = $_SESSION["usuarioUser"];
$dtultalt = date('Y-m-d H:i:s');
$empresa = strtoupper($_GET["P23"]);
$votou = $_GET["P24"];
$ramo = $_GET["P25"];
$recebemail = $_GET["P26"];
$recimpresso = $_GET["P27"];
$campanha = $_GET["P29"];
$facebook = $_GET["P30"];
$twitter = $_GET["P31"];
$outra = $_GET["P32"];
$enviado = $_GET["P33"];
$apelido = strtoupper($_GET["P34"]);
$estciv = $_GET["P35"];
$class = $_GET["P36"];
$_SESSION['ult_eleitor_pesquisado'] = $codigo;

// CODIGO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($codigo) : $codigo;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$codigo = $theValue;

	// NOME

$theValue = (!get_magic_quotes_gpc()) ? addslashes($nome) : $nome;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$nome = $theValue;

// SEXO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($sexo) : $sexo;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$sexo = $theValue;

// DTCAD

//$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtcad) : $dtcad;
//$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
//$dtcad = $theValue;

// DTNASC

$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtnasc) : $dtnasc;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$dtnasc = $theValue;

// CARGO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($cargo) : $cargo;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$cargo = $theValue;

// FONE_RES

$theValue = (!get_magic_quotes_gpc()) ? addslashes($fone_res) : $fone_res;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fone_res = $theValue;

// FONE_CEL

$theValue = (!get_magic_quotes_gpc()) ? addslashes($fone_cel) : $fone_cel;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fone_cel = $theValue;

// FONE_COM

$theValue = (!get_magic_quotes_gpc()) ? addslashes($fone_com) : $fone_com;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$fone_com = $theValue;

// CPF

$theValue = (!get_magic_quotes_gpc()) ? addslashes($cpf) : $cpf;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$cpf = $theValue;

// OBS

$theValue = (!get_magic_quotes_gpc()) ? addslashes($obs) : $obs;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$obs = $theValue;

// CONDICAO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($condicao) : $condicao;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$condicao = $theValue;

// EMAIL

$theValue = (!get_magic_quotes_gpc()) ? addslashes($email) : $email;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$email = $theValue;

// GRUPO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($grupo) : $grupo;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$grupo = $theValue;

// ORIGEM

$theValue = (!get_magic_quotes_gpc()) ? addslashes($origem) : $origem;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$origem = $theValue;

// PROFISSAO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($profissao) : $profissao;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$profissao = $theValue;

// ZONAL

$theValue = (!get_magic_quotes_gpc()) ? addslashes($zonal) : $zonal;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$zonal = $theValue;

// SECCAO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($seccao) : $seccao;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$seccao = $theValue;

// PAI_MAE

$theValue = (!get_magic_quotes_gpc()) ? addslashes($pai_mae) : $pai_mae;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$pai_mae = $theValue;

// FILIADO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($filiado) : $filiado;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$filiado = $theValue;

// RECEBEMAT

$theValue = (!get_magic_quotes_gpc()) ? addslashes($recebemat) : $recebemat;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$recebemat = $theValue;

// RESPCADASTRO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($respcadastro) : $respcadastro;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$respcadastro= $theValue;

// DTULTALT

//$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtultalt) : $dtultalt;
//$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
//$dtultalt = $theValue;

// EMPRESA

$theValue = (!get_magic_quotes_gpc()) ? addslashes($empresa) : $empresa;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$empresa = $theValue;

// VOTOU

$theValue = (!get_magic_quotes_gpc()) ? addslashes($votou) : $votou;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$votou = $theValue;

// RAMO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($ramo) : $ramo;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$ramo = $theValue;

// RECEBEMAIL

$theValue = (!get_magic_quotes_gpc()) ? addslashes($recebemail) : $recebemail;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$recebemail = $theValue;

// IMPRESSO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($recimpresso) : $recimpresso;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$recimpresso = $theValue;

// CAMPANHA

$theValue = (!get_magic_quotes_gpc()) ? addslashes($campanha) : $campanha;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$campanha = $theValue;

// FACEBOOK

$theValue = (!get_magic_quotes_gpc()) ? addslashes($facebook) : $facebook;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$facebook = $theValue;

// TWITTER

$theValue = (!get_magic_quotes_gpc()) ? addslashes($twitter) : $twitter;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$twitter = $theValue;

// OUTRA REDE SOCIAL

$theValue = (!get_magic_quotes_gpc()) ? addslashes($outra) : $outra;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$outra = $theValue;

// ENVIADO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($enviado) : $enviado;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$enviado = $theValue;

// APELIDO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($apelido) : $apelido;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$apelido = $theValue;

// ESTADO CIVIL

$theValue = (!get_magic_quotes_gpc()) ? addslashes($estciv) : $estciv;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$estciv = $theValue;

// CLASSIFICAçÂO

$theValue = (!get_magic_quotes_gpc()) ? addslashes($class) : $class;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$class = $theValue;

// altera no banco

$strsql = 'UPDATE cadastro SET ';
$strsql .= "NOME =".$nome;
$strsql .= ",SEXO =".$sexo;
$strsql .= ",DTNASC=".$dtnasc;
$strsql .= ",CARGO=".$cargo;
$strsql .= ",FONE_RES=".$fone_res;
$strsql .= ",FONE_CEL=".$fone_cel;
$strsql .= ",FONE_COM=".$fone_com;
$strsql .= ",CPF=".$cpf;
$strsql .= ",CONDICAO=".$condicao;
$strsql .= ",EMAIL=".$email;
$strsql .= ",GRUPO=".$grupo;
$strsql .= ",ORIGEM=".$origem;
$strsql .= ",PROFISSAO=".$profissao;
$strsql .= ",ZONAL=".$zonal;
$strsql .= ",SECCAO=".$seccao;
$strsql .= ",PAI_MAE=".$pai_mae;
$strsql .= ",FILIADO=".$filiado;
$strsql .= ",RECEBEMAT=".$recebemat;
$strsql .= ",RESPCADASTRO=".$respcadastro;
$strsql .= ",DTULTALT='".date('Y-m-d H:i:s')."'";
$strsql .= ",EMPRESA=".$empresa;
$strsql .= ",VOTOU=".$votou;
$strsql .= ",RAMO=".$ramo;
$strsql .= ",RECEBEMAIL=".$recebemail;
$strsql .= ",IMPRESSO=".$recimpresso;
$strsql .= ",ENVIADO=".$enviado;
$strsql .= ",CAMPANHA=".$campanha;
$strsql .= ",FACEBOOK=".$facebook;
$strsql .= ",TWITTER=".$twitter;
$strsql .= ",OUTRAREDE=".$outra;
$strsql .= ",APELIDO=".$apelido;
$strsql .= ",EST_CIVIL=".$estciv;
$strsql .= ",CLASSI=".$class;
$strsql .= ",OBS=".$obs;
$strsql .= ' WHERE CODIGO='.$codigo;

//echo $strsql;
//debug();
gravaoperacoes("Cadastro","A", $_SESSION["usuarioUser"],$strsql);
unset($_SESSION['msg']);
executa_sql($strsql,"Cadastro atualizado com sucesso","ERRO ao atualizar cadastro",false,false);
echo "<script>";
echo "PesquisaEleitor($codigo);";
echo 'alert("Cadastro atualizado com sucesso");';
echo "</script>";

?>