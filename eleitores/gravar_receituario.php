<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');

$funcao = $_GET['funcao'];
$_SESSION['tab']= 6;

$medicacao = "NULL";
$data_receita = htmlspecialchars(filter_input(INPUT_POST, 'data_receita',FILTER_DEFAULT));
$cod_cadastro = htmlspecialchars(filter_input(INPUT_POST, 'cod_cadastro',FILTER_DEFAULT));
$id = htmlspecialchars(filter_input(INPUT_POST, 'id',FILTER_DEFAULT));
$controlado = htmlspecialchars(filter_input(INPUT_POST, 'controlado',FILTER_DEFAULT));
$tp_uso = htmlspecialchars(filter_input(INPUT_POST, 'tp_uso',FILTER_DEFAULT));

// Data Receita
$theValue = (!get_magic_quotes_gpc()) ? addslashes($data_receita) : $data_receita;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$data_receita = $theValue;


$theValue = (!get_magic_quotes_gpc()) ? addslashes($controlado) : $controlado;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$controlado = $theValue;

$theValue = (!get_magic_quotes_gpc()) ? addslashes($tp_uso) : $tp_uso;
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
$tp_uso = $theValue;

if ($funcao == 0) { //alteração
	$id = htmlspecialchars(filter_input(INPUT_POST, 'id_receituario',FILTER_DEFAULT));
	// altera no banco	
	$strsql = 'UPDATE receituario SET ';
	$strsql .= 'data ='.$data_receita;
	$strsql .= ', tp_uso ='.$tp_uso;
	$strsql .= ', controlado ='.$controlado;
	$strsql .= ' WHERE id='.$id;
	gravaoperacoes("receituario","A", $_SESSION["usuarioUser"],"Receituário #: ".$id);
	$ret = executa_sql($strsql,"Receituário alterado com sucesso","ERRO ao alterar Recedituário",true,false);  
  	header("Location: receituario.php?id=".$id);
} else {
	$id = "NULL";
	$strsql = 'INSERT into receituario VALUES(';
	$strsql .= $id;
	$strsql .= ",".$cod_cadastro;
	$strsql .= ",".$data_receita;
	$strsql .= ",".$tp_uso;
	$strsql .= ",".$controlado;
	$strsql .= ")";
	gravaoperacoes("receituario","I", $_SESSION["usuarioUser"],"Receituário para : ".$cod_cadastro);	
	$ret = executa_sql($strsql,"Receituário gravado com sucesso","ERRO ao gravar Receituário",true,false);
	$sql = 'SELECT MAX(id) AS codigo_receita FROM receituario';
	$mysql_query = $_con->query($sql);
	if ($mysql_query->num_rows<1) {
		echo '<script>alert("ERRO ao ler receituário!");</script>';					
	}else{
		while ($dados_rec = $mysql_query->fetch_assoc()) {
			$id = $dados_rec['codigo_receita'];
			//echo $sql." - ".$id;
		}
	}
//	header("Location: receituario.php?id=".$id);
	echo "<script>document.location='receituario.php?id=$id';</script>";	}

?>