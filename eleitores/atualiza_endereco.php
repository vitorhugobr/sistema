<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina();
include("../utilitarios/funcoes.php");
$id = $_GET['P0'];
$codigo = $_GET['P1'];
$cep = $_GET['P2'];
$tipolog = strtoupper($_GET['P3']);
$rua = strtoupper($_GET['P4']);
$bairro = strtoupper($_GET['P5']);
$cidade = strtoupper($_GET['P6']);
$uf = strtoupper($_GET['P7']);
$numero = $_GET['P8'];
$compl = strtoupper($_GET['P9']);
$padrao = $_GET['P10'];
$tipo = strtoupper($_GET['P11']);
$reg = $_GET['P12'];

$respcadastro = $_SESSION["usuarioUser"];
$usuario = $_SESSION["usuarioUser"];
$dtultalt = date("d/m/Y");


$codigo2 = $codigo;
$endereco = $tipolog." ".$rua." ".$numero." ".$compl.' '.$bairro.' '.$cidade.' '.$uf.' '.$cep;

$_SESSION['ult_eleitor_pesquisado']=$codigo;

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
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
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

// RESPCADASTRO
$theValue = (!get_magic_quotes_gpc()) ? addslashes($respcadastro) : $respcadastro;
$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
$respcadastro= $theValue;


// DTULTALT
$theValue = (!get_magic_quotes_gpc()) ? addslashes($dtultalt) : $dtultalt;
$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
$dtultalt = $theValue;

$_sql = "Update enderecos set ";
	$_sql.= "codigo=".$codigo;
	$_sql.= ",cep=".$cep;
	$_sql.= ",tipolog=".$tipolog;
	$_sql.= ",rua=".$rua;
	$_sql.= ",bairro=".$bairro;
	$_sql.= ",cidade=".$cidade;
	$_sql.= ",uf=".$uf;
	$_sql.= ",numero=".$numero;
	$_sql.= ",complemento=".$compl;
	$_sql.= ",padrao=".$padrao;
	$_sql.= ",tipo=".$tipo;
	$_sql.= ",reg=".$reg;
	$_sql.= " where id=".$id;
	//$_res = $_con->query($_sql);

gravaoperacoes("enderecos","A", $_SESSION["usuarioUser"],"comando : ".$_sql);

  $pdo = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['banco'].";",$_SESSION['usuario'], $_SESSION['senha']);

  $pdo->exec("set names utf8");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  array(PDO::ATTR_PERSISTENT => true);
  try{
      $statementSql = $pdo->prepare($_sql);
      $statementSql->execute();
      return $statementSql->rowCount();
  }catch(PDOException $e){  // Caso ocorra algum erro exibe a mensagem
      if ($e->errorInfo[1] == 1062) {      // duplicate entry, do something else
          $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro.". JÁ EXISTE ESTE REGISTRO!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  		
      } else {      // an error other than duplicate entry occurred
          $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro." Motivo:\n".$e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  			
      }
      //die;
  }
  $pdo= null;


//executa_sql($_sql,"Endereço alterado com sucesso ","Endereço NÃO alterado",false,false);
	

	// altera no banco
	
$strsql = 'UPDATE cadastro SET ';
	$strsql .= "RESPCADASTRO=".$respcadastro;
	$strsql .= ",DTULTALT=".$dtultalt;
	$strsql .= ' WHERE CODIGO='.$codigo;
/*	echo '<script>alert("'.$strsql.'")</script>';*/

//executa_sql($strsql,"Endereço alterado com sucesso ","Endereço NÃO alterado",true,true);
  $pdo = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['banco'].";",$_SESSION['usuario'], $_SESSION['senha']);

  $pdo->exec("set names utf8");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  array(PDO::ATTR_PERSISTENT => true);
  try{
      $statementSql = $pdo->prepare($strsql);
      $statementSql->execute();
      return $statementSql->rowCount();
  }catch(PDOException $e){  // Caso ocorra algum erro exibe a mensagem
      if ($e->errorInfo[1] == 1062) {      // duplicate entry, do something else
          $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro.". JÁ EXISTE ESTE REGISTRO!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  		
      } else {      // an error other than duplicate entry occurred
          $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'' role='alert'><i class='fas fa-exclamation' aria-hidden='true text-muted' aria-hidden='true'></i> ".$msgerro." Motivo:\n".$e->getMessage()."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  			
      }
      //die;
  }
  $pdo= null;


?>
