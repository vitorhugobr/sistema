<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca ramos no banco de dados	*/
require_once('../utilitarios/funcoes.php');
$query = "SELECT * from ramo WHERE CODIGO = ".$_GET['ramo'];
$mysql_query = $_concomum->query($query);
if ($mysql_query->num_rows<1) {
		echo '<script>alert("RAMO não encontrado!");</script>';					
} else {
	while ($_row = $mysql_query->fetch_assoc()) {
		echo '<fieldset><div class="col-sm-12"><label>Ramo: ';
		echo $_row["CODIGO"];
		echo '</label></div>
					<br><div class="col-sm-12">
					 Descrição: <input class="form-control" type="text" name="txtdescricao" value = "';
		echo strtoupper($_row["DESCRICAO"]);
		echo '"size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>';
		$botaog = '<div class="col-sm-12"><button type="button" class="btn btn-sm btn-success" onclick="javascript:altera_Ramo('.$_row["CODIGO"].');"> <i class="fas fa-refresh"></i> Alterar </button></div>';
		echo $botaog;
		echo '</fieldset>';
	}
}		
?>

