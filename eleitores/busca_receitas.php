<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
if ($_SESSION['usuarioCodigo']>1){
	alert('Não vai buscar receitas');
	return;
}

$primeira=true;
$query = "SELECT * from receituario_view WHERE cod_cadastro = ".$_GET['cod']." order by data desc";
$mysql_query = $_con->query($query);
$qtderegs = $mysql_query->num_rows;
$tabela = '<div class="table-responsive container-fluid"><table class="table-bordless">
			<tr>
				<td colspan="4">
					<button type="button" onclick="javascript:inclui_receituario('.$_GET["cod"].')" class="btn btn-sm btn-primary"><i class="fas fa-plus" aria-hidden="true"></i> Novo Receituário </button>
				</td>
			</tr>';


if ($qtderegs==0) {
	$tabela .= '<strong>SEM RECEITAS</strong>';
}else{
	$linha = 1;
	while ($dados_receita = $mysql_query->fetch_assoc()) {
		if ($linha == 1) {
			$classe = 'class="bg-light"';
			$linha =2;
		}else {
			$classe = 'class="bg-transparent"';
			$linha =1;
		}
		$tp_uso = $dados_receita['tp_uso'];
		if ($tp_uso == 0){
			$tp_uso = "Interno";
		}else {
			$tp_uso = "Externo";
		}
		$diago = "";
		$controlado = $dados_receita['controlado'];
		if ($controlado == 0){
			$controlado = "Não";
		}else {
			$controlado = "Sim";
		}
		$tabela .= '  
			<tr '.$classe.'>
			<td align="right" width="10%"><strong>Data da Receita:&nbsp;</strong></td>
			<td width="75%">'.FormatDateTime($dados_receita["data"],7).'</td>
			<td width="5%">
				<button type="button" onclick="javascript:mostra_receituario('.$dados_receita['id'].')" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button>
			</td>
			<td width="5%">
				<button type="button" onclick="';
				if ($controlado=="Sim"){
					$tabela .= "imprime_receituario_especial(".$dados_receita['id'].")";
				}else{
					$tabela .= "imprime_receituario(".$dados_receita['id'].")";
				}					
				$tabela .= '" class="btn btn-sm btn-success btn-block"><i class="fas fa-print" aria-hidden="true"></i> Imprimir</button>
			</td>
			<td width="5%">
				<a href="#" onclick="javascript:excluir_receituario('.$dados_receita['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir
				</a>
			</td>
			</tr>
			<tr '.$classe.'>
			<td align="right" valign="top"><strong>Controle Especial:&nbsp;</strong></td>
			<td colspan="4" valign="top">'.$controlado.'</td>
			</tr>
			<tr '.$classe.'>
			<td align="right" valign="top"><strong>Tipo de Uso:&nbsp;</strong></td>
			<td colspan="4" valign="top">'.$tp_uso.'</td>
			</td>
			</tr>
  	</tr>
		<tr '.$classe.'>
			<td align="right" valign="top"><strong>Medicamento(s):&nbsp;</strong></td>
';
		$query2 = "SELECT * from dados_receita WHERE cod_receita = ".$dados_receita['id'];
		$mysql_query2 = $_con->query($query2);
		$primeiro = 0;
		if ($mysql_query2->num_rows==0) {
			$tabela .= '<td colspan ="4"><span class="text-danger"><strong>SEM MEDICAMENTOS NESTA RECEITA</strong></span></td></tr>';
		}else{
			while ($remedios = $mysql_query2->fetch_assoc()) {
				$medicamento = $remedios['medicamento'];
				$qtde = $remedios['qtde'];
				$posologia = $remedios['posologia'];
				if ($primeiro==0){
					$tabela .= 
						'<td colspan="4" width="80%" align="left"><strong>'.$medicamento.'&nbsp;&nbsp;->'.$qtde.'</strong></td>
						</tr>
						<tr '.$classe.'>
							<td width="5%"></td>
							<td colspan="4" align="left">'.$posologia.'</td>
						</tr>';	
					$primeiro=1;	
				}else{
					$tabela .= 
						'<tr '.$classe.'>
							<td width="5%"></td>
							<td colspan="4" width="80%" align="left"><strong>'.$medicamento.'&nbsp;&nbsp;->'.$qtde.'</strong></td>
						</tr>
						<tr '.$classe.'>
							<td width="5%"></td>
							<td colspan="4" align="left">'.$posologia.'</td>
						</tr>';				
					}

			}
		}
	}		
}
$tabela .='</table></div>';
echo $tabela;
?>



