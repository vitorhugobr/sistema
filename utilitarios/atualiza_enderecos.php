<?php
date_default_timezone_set('America/Sao_Paulo');
$_SESSION['servidor'] = "www.serverwebdb.com.br";
$_SESSION['banco'] = "chaplinb_chaplin";
$_SESSION['usuario'] = "chaplinb_chaplin";
$_SESSION['senha'] = "HpcOKYN7b2E-";

$_con  = new mysqli($_SESSION['servidor'],$_SESSION['usuario'], $_SESSION['senha'],$_SESSION['banco']);	
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

set_time_limit(0); // 
$horaini = date("d-m-Y H:i:s");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atualizando Endereços</title>
</head>
<body>
<h4><?php
echo("Início :".date("d-m-Y H:i:s"));
    ?></h4><pre>
<?php
$atualizados = 0;
$naopertence = 0;
$query = "select * from teste1";
echo $query."<br>";
$mysql_query = $_con->query($query);
while ($db_cad = $mysql_query->fetch_assoc()) {
	$code = $db_cad["CODIGO"];
	$pdo = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['banco'].";",$_SESSION['usuario'], $_SESSION['senha']);    
	$pdo->exec("set names utf8");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	array(PDO::ATTR_PERSISTENT => true);
	$query = "DELETE from enderecos where codigo = ".$code;
	$atualizados++;
	try{
		$statementSql = $pdo->prepare($query);
		$statementSql->execute();
		echo "CÓDIGO excluído: ".$code."<br>";
	}catch(PDOException $e){  // Caso ocorra algum erro exibe a mensagem
		echo 'ERRO -> '.$code.' Exceção: '.$e->getMessage().'<br>';
	}
	$pdo= null;
}
echo("<br>Fim! ".date("d-m-Y H:i:s"));
echo("<br>Atualizados: ".$atualizados);
//echo("<br>".$query);
 ?>
</pre>
</body>
</html>