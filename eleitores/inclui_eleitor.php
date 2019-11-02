<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina();
include("../utilitarios/funcoes.php");
//			GERA O NOVO CODIGO PARA O CADASTRO
date_default_timezone_set('America/Sao_Paulo');


$codigo = NULL;	
$nome = strtoupper($_GET["P1"]);	
$nome = strtoupper($nome);
$sexo = $_GET["P2"];
$dtnasc = $_GET["P4"];		
$cargo = strtoupper($_GET["P5"]);
$fone_res = $_GET["P6"];
$fone_cel = $_GET["P7"];
$fone_com = $_GET["P8"];
$cpf = $_GET["P9"];	
$obs = $_GET["P10"];
if ($obs<>""){	
	$obs = strtoupper($obs);
}else{
	$obs = "";
}
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
$empresa = strtoupper($_GET["P23"]);
$votou = $_GET["P24"];
$ramo = $_GET["P25"];
$recebemail = $_GET["P26"];
$recimpresso = $_GET["P27"];
$enviado = 0;
$campanha = $_GET["P29"];
$facebook = $_GET["P30"];
$twitter = $_GET["P31"];
$outra = $_GET["P32"];
$enviado = $_GET["P33"];
$apelido = $_GET["P34"];
$estciv = $_GET["P35"];
$class = $_GET["P36"];
if ($apelido<>""){	
	$apelido = strtoupper($apelido);
}else{
	$apelido = "";
}
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
$date = date_create();
$dtcad = date_format($date, 'Y-m-d H:i:s');
$dtcad = date_create()->format('Y-m-d H:i:s');
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtcad) : $dtcad;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$dtcad = $theValue;

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
$theValue = ($theValue != "") ? intval($theValue) : "0";
$zonal = $theValue;

// SECCAO
$theValue = (!get_magic_quotes_gpc()) ? addslashes($seccao) : $seccao;
$theValue = ($theValue != "") ? intval($theValue) : "0";
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
$date = date_create();
$dtultalt = date_format($date, 'Y-m-d H:i:s');
$dtultalt = date_create()->format('Y-m-d H:i:s');
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtultalt) : $dtultalt;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$dtultalt = $theValue;

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
//debug();
$strsql = 'INSERT into cadastro VALUES(';
$strsql .= $codigo;
$strsql .= ",".$nome;
$strsql .= ",".$sexo;
$strsql .= ",'".date('Y-m-d H:i:s')."'";
$strsql .= ",".$dtnasc;
$strsql .= ",".$cargo;
$strsql .= ",".$fone_res;
$strsql .= ",".$fone_cel;
$strsql .= ",".$fone_com;
$strsql .= ",".$cpf;
$strsql .= ",".$condicao;
$strsql .= ",".$email;
$strsql .= ",".$grupo;
$strsql .= ",".$origem;
$strsql .= ",".$profissao;
$strsql .= ",".$zonal;
$strsql .= ",".$seccao;
$strsql .= ",".$pai_mae;
$strsql .= ",".$filiado;
$strsql .= ",".$recebemat;
$strsql .= ",".$respcadastro;
$strsql .= ",'".date('Y-m-d H:i:s')."'";
$strsql .= ",".$empresa;
$strsql .= ",".$votou;
$strsql .= ",".$ramo;
$strsql .= ",".$recebemail;
$strsql .= ",".$recimpresso;
$strsql .= ",".$enviado;
$strsql .= ",".$campanha;
$strsql .= ",".$facebook;
$strsql .= ",".$twitter;
$strsql .= ",".$outra;
$strsql .= ",".$apelido;
$strsql .= ",".$estciv;
$strsql .= ",".$class;
$strsql .= ",".$obs;
$strsql .= ')';

//echo $strsql;
gravaoperacoes("cadastro","I", $_SESSION["usuarioUser"],$strsql);

$resposta = executa_sql($strsql,"Cadastro incluído com sucesso","Cadastro NÃO incluído",true,true);

$_SESSION['set_alterou'] = false;

$sql = 'SELECT MAX(CODIGO) AS codigo FROM cadastro';
$mysql_query = $_con->query($sql);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("ERRO ao ler cadastro!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$_SESSION['ult_eleitor_pesquisado']=$dados_s['codigo'];
		echo '<script>';
		echo 'document.form1.txtcodigo.value = '.$dados_s['codigo'];
		echo 'document.getElementById("btnincend").disabled = false;';
		echo '</script>';
	}
}


?>