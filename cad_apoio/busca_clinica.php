<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*
Busca profissaos no banco de dados	*/
require_once('../utilitarios/funcoes.php');
$query = "SELECT * from clinicas WHERE id = ".$_GET['clinica'];
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows<1) {
		echo '<script>alert("Clinica não encontrado!");</script>';					
} else {
	while ($_row = $mysql_query->fetch_assoc()) {
		echo '<fieldset><div class="col-sm-12"><label>Clinica: ';
		echo $_row["id"];
		echo '</label></div>
					<br><div class="col-sm-12">
					 Nome da Clínica: <input class="form-control" type="text" name="txtdescricao" value = "';
		echo strtoupper($_row["clinica"]);
		echo '"size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>
				<br><div class="col-sm-12">
					 Endereço da Clínica: <input class="form-control" type="text" name="txtendereco" value = "';
		echo strtoupper($_row["endereco"]);
		echo '"size="50" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>
				<br><div class="col-sm-12">
					 Telefone da Clínica: <input class="form-control" type="text" name="txtfone" value = "';
		echo strtoupper($_row["telefone"]);
		echo '"size="20" onChange="javascript:this.value=this.value.toUpperCase();" autofocus/></div>';
		$botaog = '<div class="col-sm-12"><button type="button" class="btn btn-sm btn-success" onclick="javascript:altera_clinica('.$_row["clinica"].');"> <i class="fas fa-refresh"></i> Alterar </button></div>';
		echo $botaog;
		echo '</fieldset>';
	}
}		
?>

