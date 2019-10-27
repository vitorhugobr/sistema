<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina();
include("../utilitarios/funcoes.php");
//			GERA O NOVO CODIGO PARA O CADASTRO
date_default_timezone_set('America/Sao_Paulo');

$codigo = NULL;	
$nome = "";	
$sexo = "";
$dtnasc = "";		
$cargo = "";
$fone_res = "";
$fone_cel = "";
$fone_com = "";
$cpf = "";	
$condicao = 1;
$email = "";
$email = "";
$grupo = "";		
$origem = "";		
$profissao = "";
$zonal = "";
$seccao = "";
$pai_mae = "";
$filiado = "";
$recebemat = "";
$respcadastro = $_SESSION["usuarioUser"];
$empresa = "";
$votou = "";
$ramo = "";
$recebemail = "";
$recimpresso = "";
$enviado = 0;
$campanha = "";
$facebook = "";
$twitter = "";
$outra = "";
$enviado = "";
$apelido = "";
$estciv = "";
$class = "";
$apelido = "";
$obs="";

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
$strsql = 'INSERT into cadastro (CODIGO, DTCAD, CONDICAO, RESPCADASTRO, DTULTALT)  VALUES(';
$strsql .= $codigo;
$strsql .= ",'".date('Y-m-d H:i:s')."'";
$strsql .= ",".$condicao;
$strsql .= ",".$respcadastro;
$strsql .= ",'".date('Y-m-d H:i:s')."'";
$strsql .= ')';

//echo $strsql;
$mysql_query1 = $_con->query($strsql);
    
if ($mysql_query1) {
	$sql = 'SELECT MAX(CODIGO) AS codigo FROM cadastro';
	$mysql_query = $conn->query($sql);
	if ($mysql_query->num_rows<1) {
		echo '<script>alert("ERRO ao ler cadastro!");</script>';					
	}else{
		while ($dados_s = $mysql_query->fetch_assoc()) {
			$_SESSION['ult_eleitor_pesquisado']=$dados_s['codigo'];
			echo '<script>';
			echo 'PesquisaEleitor('.$dados_s['codigo'].')';
			echo '</script>';
		}
	}
	exit;
}else{	
	//rollback(); // failed so roll back transaction
			echo '<script>';
			echo 'document.form1.txtobs.value = "'.$strsql.'";';
			echo '</script>';
}


?>