<?php
$local_acesso = "acesso local";

//----------------------------------------------------------------------------
// Vitor POA
switch ($_SESSION['id']) {
	case 0:  // Local Testes
		$_SG['servidor'] = "localhost";
		$_SG['usuario'] = "root";
		$_SG['senha'] = "";
		$_SG['banco'] = "thiago_sigre"; // LOCAL thiago
		break;		
	case 1:  //Dr Thiago
		$_SG['servidor'] = "191.252.101.58";
		$_SG['banco'] = "drthiago_sigre";
		$_SG['usuario'] = "sigre";
		$_SG['senha'] = "sigre2018";
		//	senha cpanel:   usuário: 
		break;
	case 2:  // Pujol
		$_SG['servidor'] = "www.rpujol.com.br";
		$_SG['banco'] = "rpujolco_pujol";
		$_SG['usuario'] = "rpujolco_pujol";
		$_SG['senha'] = "vhm@2019";
		//  senha cpanel: "VHMO@@2019"  usuário: "rpujolcom"
		break;
	case 3:  // Mauro Pinheiro
		$_SG['servidor'] = "www.mauropinheiro.net.br";
		$_SG['banco'] = "mauropin_mauro";
		$_SG['usuario'] = "mauropinheironet";
		$_SG['senha'] = "UIT8765%kuyi&*";
		//	senha cpanel: "UIT8765%kuyi&*"  usuário: "mauropinheironet"
		break;
	case 4:  // Domingos Cunha
		$_SG['servidor'] = "www.domingoscunha.com.br";
		$_SG['banco'] = "domingos_domingos";
		$_SG['usuario'] = "domingos_domingo";
		$_SG['senha'] = "domi@2019";
		//	senha cpanel: "%Yb[2,XNP=D%"  usuário: "domingoscunhacom"
		break;
	case 5:  // Tessaro
		$_SG['servidor'] = "www.vereadortessaro.com.br";
		$_SG['banco'] = "vereador_sigre";
		$_SG['usuario'] = "vereador_tessaro";
		$_SG['senha'] = "tessaro@2019";
		//	senha cpanel:    usuário: 
		break;
	case 6:  // Democratas Porto Alegre
		$_SG['servidor'] = "www.rpujol.com.br";
		$_SG['banco'] = "rpujolco_dem";
		$_SG['usuario'] = "rpujolco_dem";
		$_SG['senha'] = "democrataspoa@2019";
		//	senha cpanel: "VHMO@@2019"  usuário: "rpujolcom"
		break;
	case 7:  // Sebastião Melo
		$_SG['servidor'] = "www.sebastiaomelo.poa.br";
		$_SG['usuario'] = "sebastia_melo";
		$_SG['senha'] = "lmqY{uxa(WrL";
		$_SG['banco'] = "sebastia_sigre"; 
		//	senha cpanel: "=1fTUSoRJ}Ru"  usuário: "sebastiaomelopoa"
		break;
}

// -------------------------------------------------------------------------
$_SG['servidorcomum'] = "www.vitor.poa.br";
$_SG['bancocomum'] = "vitorpoa_teste";
$_SG['usuariocomum'] = "vitorpoa_user";
$_SG['senhacomum'] = "vhmo@2017";
//----------------------------------------------------------------------------
// variáveis definidas para tabelas com uso comum localizadas no bd vitor_poa e acessadas por todos 
define("HOSTCOMUM", $_SG['servidorcomum']);
define("USERCOMUM", $_SG['usuariocomum']);
define("PASSCOMUM", $_SG['senhacomum']);
define("DBCOMUM", $_SG['bancocomum']);
$_concomum  = new mysqli($_SG['servidorcomum'],$_SG['usuariocomum'],$_SG['senhacomum'],$_SG['bancocomum']);	
if(!$_concomum) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
mysqli_set_charset($_concomum,"utf8");
mysqli_query($_concomum, "SET NAMES 'utf8'");
mysqli_query($_concomum, 'SET character_set_connection=utf8');
mysqli_query($_concomum, 'SET character_set_client=utf8');
mysqli_query($_concomum, 'SET character_set_results=utf8');
try{
  // Faz conexão com banco de daddos
  $pdocomum = new PDO("mysql:host=".HOSTCOMUM.";dbname=".DBCOMUM.";",USERCOMUM, PASSCOMUM);
  $pdocomum->exec("set names utf8");
  array(PDO::ATTR_PERSISTENT => true);
}catch(PDOException $e){
  // Caso ocorra algum erro na conexão com o banco, exibe a mensagem
  echo 'Falha ao conectar no banco de dados: '.$e->getMessage();
  die;
}

//----------------------------------------------------------------------------
define("HOST", $_SG['servidor']);
define("USER", $_SG['usuario']);
define("PASS", $_SG['senha']);
define("DB", $_SG['banco']);
define("ACESSO_LOC", $local_acesso);
$conn = mysqli_connect($_SG['servidor'],$_SG['usuario'], $_SG['senha'],$_SG['banco']);
$_con  = new mysqli($_SG['servidor'],$_SG['usuario'],$_SG['senha'],$_SG['banco']);	
if(!$_con) {  
	echo "Não foi possivel conectar ao MySQL. Erro " .
			mysqli_connect_errno() . " : " . mysql_connect_error();
	exit;
}
mysqli_set_charset($_con,"utf8");
mysqli_query($_con, "SET NAMES 'utf8'");
mysqli_query($_con, 'SET character_set_connection=utf8');
mysqli_query($_con, 'SET character_set_client=utf8');
mysqli_query($_con, 'SET character_set_results=utf8');
//---------------------------------------------------------
mysqli_set_charset($conn,"utf8");
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, 'SET character_set_connection=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
try{
  // Faz conexão com banco de daddos
  $pdo = new PDO("mysql:host=".HOST.";dbname=".DB.";",USER, PASS);
  $pdo->exec("set names utf8");
  array(PDO::ATTR_PERSISTENT => true);
}catch(PDOException $e){
  // Caso ocorra algum erro na conexão com o banco, exibe a mensagem
  echo 'Falha ao conectar no banco de dados: '.$e->getMessage();
  die;
}
?>