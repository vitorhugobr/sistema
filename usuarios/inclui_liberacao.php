<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
include_once("../utilitarios/funcoes.php");

$usu = $_GET['usu'];
//echo $usu;
$_sql1 = "Delete from liberacao where username = '".$usu."'";
$_res1  = executa_sql($_sql1,"","ERRO ao excluir liberações",false,false);;
gravaoperacoes("liberacao","I",$_SESSION["usuarioUser"],"Incluídas lilberações para usuário ".$usu);
$_sql = "SELECT cod_item_menu from menu";
$_res = $_con->query($_sql);
//echo '<br> Registros lidos= '.$_res->num_rows.'<br>';
if($_res->num_rows==0) {
	echo '<script>alert("Arquivo de MENU não encontrado!");	
	</script>';							
} else {
	while($_row = $_res->fetch_assoc()) {
		foreach ($_row as $campo => $valor) {
			$cod_menu = $_row["cod_item_menu"];
//			echo $cod_menu. ' ----> valor: ';
			$valor = ($_GET["Z".$cod_menu]);
//			echo $valor.'<br>';
			if ($valor==1){
				$_sql2  = "Insert into liberacao values('$usu','".strtoupper($cod_menu)."')";
//				echo 'insert na liberacao '.$_sql2;
				$_res2  = executa_sql($_sql2,"Autorizações de Acesso para <strong>".$usu."</strong> atualizadas com sucesso!","ERRO ao incluir liberações",true,false);;
			}
		}
	}
//	// vai inserir a funcao de SAIR do menu
//	$_sql2  = "Insert into liberacao values('$usu','99999')";
//	$_res2  = $_con->query($_sql2);
}					
$_con->close();			
echo '<script>location.reload();</script>';


?>