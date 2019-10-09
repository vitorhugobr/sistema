<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
/*
Busca profissaos no banco de dados	*/
$query = "SELECT * from cadastro_exames WHERE id = ".$_GET['id'];
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows<1) {
		echo '<script>alert("exame não encontrado!");</script>';					
} else {
	while ($_row = $mysql_query->fetch_assoc()) {
		echo '<fieldset><div class="col-sm-12"><label>Exame: ';
		echo $_row["id"];
		echo '</label></div>
					<br><div class="col-sm-12">
					 Descrição: <input class="form-control" type="text" name="txtdescricao" value = "';
		echo strtoupper($_row["descricao"]);
		echo '"size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>';
		$botaog = '<div class="col-sm-12"><button type="button" class="btn btn-sm btn-success" onclick="javascript:altera_exame('.$_row["id"].');"> <span class="fas fa-save"></span> Alterar </button></div>';
		echo $botaog;
		echo '</fieldset>';
	}
}		
?>

