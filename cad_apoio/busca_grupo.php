<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca profissaos no banco de dados	*/
require_once('../utilitarios/funcoes.php');
$query = "SELECT * from grupos WHERE GRUPO = ".$_GET['grupo'];
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows<1) {
		echo '<script>alert("GRUPO não encontrado!");</script>';					
} else {
	while ($_row = $mysql_query->fetch_assoc()) {
		echo '<fieldset><div class="col-sm-12"><label>Grupo: ';
		echo $_row["GRUPO"];
		echo '</label></div>
					<br><div class="col-sm-12">
					 Descrição: <input class="form-control" type="text" name="txtdescricao" value = "';
		echo strtoupper($_row["NOMEGRP"]);
		echo '"size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>';
		$botaog = '<div class="col-sm-12"><button type="button" class="btn btn-sm btn-success" onclick="javascript:altera_Grupo('.$_row["GRUPO"].');"> <i class="fas fa-refresh"></i> Alterar </button></div>';
		echo $botaog;
		echo '</fieldset>';
	}
}		
?>

