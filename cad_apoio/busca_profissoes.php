<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
/*Busca profissoes no banco de dados	*/
require_once('../utilitarios/funcoes.php');

$busca = "Select `profissao`.`Profissao` AS `codigo`, `profissao`.`Descricao2` AS `descricao` from  profissao order by `profissao`.`Descricao2`";


$todos = $_concomum->query("$busca");

$totalderegistros = $todos->num_rows; // verifica o número total de registros

// vamos criar a visualização
if ($totalderegistros<1) {
	echo '<script>alert("Nenhuma Profissão encontrada");</script>';					
} else {
	echo '<table class="table table-striped">
	<thead class="thead-dark">
  <tr>
    <th nowrap><i class="fas fa-hashtag"></i> Profissão</th>
    <th width="64%"><i class="fas fa-text-width"></i> Descrição</th>
    <th width="13%">th>
    <th width="13%">Opções</th>
  </tr>
	</thead><tbody>';
	
	$linha=0;
	$cor='';
	while ($dado = $todos->fetch_assoc()) {
		echo '<tr>
		<td align="right">'.$dado['codigo'].'</td>
		<td>'.strtoupper($dado['descricao']).'</td>
		<td align="right"></td>
		<td align="right">
			<img src="../imagens/excluir.jpg" alt="Excluir" width="18" height="18" onclick="excluiProfissao('.$dado['codigo'].')">&nbsp;
			<img src="../imagens/editar.png" alt="Editar" height="18" onclick="mostraprofissao('.$dado['codigo'].')"></td>
		</tr>';
	}		
	echo '</tbody></table>';		
}		

?>