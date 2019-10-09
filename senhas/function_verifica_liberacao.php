<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
function liberado($usuario,$funcao){
	$_sql = "SELECT * from liberacao WHERE username = '$usuario' and funcao = $funcao";
	$_res = $_con->query($_sql);
	if (mysqli_affected_rows($_con) > 0) {
		$volta = true;
	}else{
		$volta = false;
	}
	$_con->close();
	
	return $volta;
}
?>