<?php

$_concomum  = new mysqli($_SESSION['servidorcomum'],$_SESSION['usuariocomum'],$_SESSION['senhacomum'],$_SESSION['bancocomum']);	
if(!$_concomum) {  
	echo "Não foi possivel conectar ao MySQL " .$_SESSION['servidorcomum']."<br> Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
mysqli_set_charset($_concomum,"utf8");
mysqli_query($_concomum, "SET NAMES 'utf8'");
mysqli_query($_concomum, 'SET character_set_connection=utf8');
mysqli_query($_concomum, 'SET character_set_client=utf8');
mysqli_query($_concomum, 'SET character_set_results=utf8');
//---------------------------------------------------------

$_con  = new 
mysqli($_SESSION['servidor'],$_SESSION['usuario'], $_SESSION['senha'],$_SESSION['banco']);	
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQLi " .$_SESSION['servidor']."<br> Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
mysqli_set_charset($_con,"utf8");
mysqli_query($_con, "SET NAMES 'utf8'");
mysqli_query($_con, 'SET character_set_connection=utf8');
mysqli_query($_con, 'SET character_set_client=utf8');
mysqli_query($_con, 'SET character_set_results=utf8');
//---------------------------------------------------------
try{
  // Faz conexão com banco de daddos
  $pdo = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['banco'].";",$_SESSION['usuario'], $_SESSION['senha']);
  $pdo->exec("set names utf8");
  array(PDO::ATTR_PERSISTENT => true);
}catch(PDOException $e){
  // Caso ocorra algum erro na conexão com o banco, exibe a mensagem
  echo 'Falha ao conectar no banco de dados(pdo): '.$_SESSION['banco'].'<br>'.$e->getMessage();
  exit;
}

?>