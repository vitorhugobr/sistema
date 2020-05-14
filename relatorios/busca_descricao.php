<?php include_once("../seguranca.php");

$campoescolhido = $_GET['campoesc'];

if ($campoescolhido=="campanha"){
	$query = "SELECT codigo as id, descricao as descricao from campanha ORDER BY descricao";
	$mysql_query = $_con->query($query);
}else{
	if ($campoescolhido=="grupo"){
		$query = "SELECT GRUPO as id, NOMEGRP as descricao from grupos ORDER BY NOMEGRP";
		$mysql_query = $_con->query($query);
	}else{
		if ($campoescolhido=="origem"){
			$query = "SELECT Origem as id, Descricao as descricao from origem ORDER BY Descricao";
			$mysql_query = $_con->query($query);
		}else{
			if ($campoescolhido=="profissao"){
				$query = "SELECT Profissao as id, Descricao2 as descricao from profissao ORDER BY Descricao2";
				$mysql_query = $_concomum->query($query);
			}else{
				if ($campoescolhido=="ramo"){
					$query = "SELECT CODIGO as id, DESCRICAO as descricao from ramo ORDER BY DESCRICAO";
					$mysql_query = $_concomum->query($query);
				}else{
					$query = "SELECT id as id, label as descricao from campos ORDER BY label";
					$mysql_query = $_con->query($query);
				}
			}
		}
	}
}


//		echo $query;

if ($mysql_query->num_rows<1) {
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
    	$data[] = $dados_s; 
	}
}
echo json_encode($data);
