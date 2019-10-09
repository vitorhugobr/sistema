<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

$query = "SELECT * from prontuario_view WHERE id = ".$_GET['id'];
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows==0) {
	echo '<strong>ERRO ao ler PRONTUÁRIOS</strong>';
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		echo '<script>';
		echo 'document.form1.id_prontuario.value = "'.$dados_s['id'].'";';
		echo 'document.getElementById("lblnome").innerHTML ="'.$dados_s['nome'].'";';		
		echo 'document.form1.data_consulta.value = "'.FormatDateTime($dados_s['data_consulta'],7).'";';
		echo 'document.form1.cod_clinica.value = "'.$dados_s['clinica'].'";';
		echo 'document.form1.cod_cadastro.value = "'.$dados_s['cod_cadastro'].'";';
//		0-normal 1-baixa 2-media- 3-alta
		switch ($dados_s['prioridade']) {
				case 0:
					$prio = "Normal";
				case 1:	
					$prio = "Baixa";
				case 2:
					$prio = "Média";
				case 3:
					$prio = "Alta";
			}
		echo 'document.form1.priority.value = "'.$prio.'";';
		echo 'document.form1.prioridade.value = "'.$dados_s['prioridade'].'";';
		echo 'document.form1.diagnostic.value = "'.$dados_s['diagnostico'].'";';
		echo 'document.form1.diagnostic.focus();';
		echo '</script>';
	}		
}
?>



