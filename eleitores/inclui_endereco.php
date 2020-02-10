<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include_once("../utilitarios/funcoes.php");
$id = $_GET['P0'];
$codigo = $_GET['P1'];
$cep = $_GET['P2'];
$tipolog = $_GET['P3'];
$rua = $_GET['P4'];
$bairro = $_GET['P5'];
$cidade = $_GET['P6'];
$uf = $_GET['P7'];
$numero = $_GET['P8'];
$compl = $_GET['P9'];
$padrao = $_GET['P10'];
$tipo = $_GET['P11'];
$reg = $_GET['P12'];

$codigo2 = $codigo;
$endereco = $tipolog." ".$rua." ".$numero." ".$compl.' '.$bairro.' '.$cidade.' '.$uf.' '.$cep;

$_SESSION['ult_eleitor_pesquisado']=$codigo;

// id
$theValue = (!get_magic_quotes_gpc()) ? addslashes($id) : $id;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$id = "NULL";

// codigo
$theValue = (!get_magic_quotes_gpc()) ? addslashes($codigo) : $codigo;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$codigo = $theValue;

// cep
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cep) : $cep;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$cep = $theValue;

// tipolog
$theValue = (!get_magic_quotes_gpc()) ? addslashes($tipolog) : $tipolog;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$tipolog = $theValue;

// rua
$theValue = (!get_magic_quotes_gpc()) ? addslashes($rua) : $rua;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$rua = $theValue;

// bairro
$theValue = (!get_magic_quotes_gpc()) ? addslashes($bairro) : $bairro;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$bairro = $theValue;

// cidade
$theValue = (!get_magic_quotes_gpc()) ? addslashes($cidade) : $cidade;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$cidade = $theValue;

// uf
$theValue = (!get_magic_quotes_gpc()) ? addslashes($uf) : $uf;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "RS";
$uf = $theValue;

// numero
$theValue = (!get_magic_quotes_gpc()) ? addslashes($numero) : $numero;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$numero = $theValue;

// compl
$theValue = (!get_magic_quotes_gpc()) ? addslashes($compl) : $compl;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$compl = $theValue;

// padra
$theValue = (!get_magic_quotes_gpc()) ? addslashes($padrao) : $padrao;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$padrao = $theValue;

// tipo
$theValue = (!get_magic_quotes_gpc()) ? addslashes($tipo) : $tipo;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$tipo = $theValue;

// reg - para correios
$theValue = (!get_magic_quotes_gpc()) ? addslashes($reg) : $reg;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$reg = $theValue;

$_sql = "Insert into enderecos values(".$id.",".$codigo.",".$cep.",".$tipolog.",".$rua.",".$bairro.",".$cidade.",".$uf.",".$numero.",".$compl.",".$padrao.",".$tipo.",".$reg.")";
gravaoperacoes("enderecos","I", $_SESSION["usuarioUser"],"Incluído endereço do cadastro #: ".$codigo);

$resposta = executa_sql($_sql,"Endereço incluído com sucesso","ERRO ao incluir endereço",true,false);

#echo '<script>self.window.close();</script>';
?>