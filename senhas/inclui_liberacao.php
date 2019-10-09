<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');

$usu = $_GET['usu'];
$_sql = "Delete from liberacao where username = '".$usu."'";
$_res = $_con->query($_sql);
$_sql = "SELECT cod_item_menu from menu";
$_res = $_con->query($_sql);
if($_res->num_rows==0) {
	echo '<script>alert("Arquivo de MENU não encontrado!");	
	</script>';							
} else {
	while($_row = $_res->fetch_assoc()) {
		foreach ($_row as $campo => $valor) {
			$cod_menu = $_row["cod_item_menu"];
			$valor = ($_GET["Z".$cod_menu]);
			if ($valor==1){
				$_sql2  = "Insert into liberacao values('$usu','".strtoupper($cod_menu)."')";
				$_res2  = $_con->query($_sql2);
			}
		}
	}
}					
$_con->close();			
$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Liberações Gravadas OK<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
echo '<script>window.location.reload(true);</script>'; 
?>