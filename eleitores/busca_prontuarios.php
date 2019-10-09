<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
if ($_SESSION['usuarioCodigo']>1){
	alert('Não vai buscar prontuário');
	return;
}

$tabela='';
$cod_cadastro = $_GET["cod"];
$queryf = "SELECT * from agenda_dia_clinica WHERE cod_cadastro = ".$cod_cadastro." and situacao = 2 order by data_agenda desc";

$mysql_queryf = $_con->query($queryf);
$qtderegsf = $mysql_queryf->num_rows;
$msg = "";
//echo "<br><br><br><br>".$query."<br>".$qtderegs."<br>";
if ($qtderegsf>0) {
	while ($dadof = $mysql_queryf->fetch_assoc()) {
		$id = $dadof['id'];
	  	$data_agenda = $dadof['data_agenda']; 
		$msg .= " - ".FormatDateTime($data_agenda,7);
  	}
	$tabela .= "<div style=\"height: 40px\" class=\"alert alert-danger text-center alert-dismissible fade show\" role=\"alert\">
		<font color=\"#E50206\"><strong>Paciente já faltou ".$qtderegsf." consulta(s) em ".$msg."</strong></font>
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fechar\">
		<span aria-hidden=\"true\">&times;</span>
		</button>
		</div>";
}

$query = 'SELECT * from prontuario_view WHERE cod_cadastro = '.$cod_cadastro.' order by data_consulta desc';
$mysql_query = $_con->query($query);
$tabela .= '<div class=\"table-responsive container-fluid\"><table class=\"table-striped\">
	<tr>
		<td colspan=\"4\">';
$tabela .= '<a href="#" title="Imprime atestado padrão" onclick="javascript:imprime_atestado('.$cod_cadastro.')" class="btn btn-sm btn-info" />			<i class="fas fa-file-medical" aria-hidden="true"></i> Atestado</a>';
$tabela .='</td>
		</tr>';
if ($mysql_query->num_rows==0) {
	$tabela .= '<tr><td><strong>SEM PRONTUÁRIOS</strong></td></tr>';
}else{
	$linha = 1;
	while ($dados_prontuario = $mysql_query->fetch_assoc()) {
		if ($linha == 1) {
			$classe = 'class="bg-light"';
			$linha =2;
		}else {
			$classe = 'class="bg-white"';
			$linha =1;
		}
		$diago = $dados_prontuario['diagnostico'];
		$tabela .= '  
			<tr '.$classe.'>
			<td align="right" width="10%"><strong>Data da Consulta:&nbsp;</strong></td>
			<td width="80%">'.FormatDateTime($dados_prontuario['data_consulta'],7).'</td>
			<td width="5%">
				<button type="button" onclick="javascript:mostra_prontuario('.$dados_prontuario['id'].')" class="btn btn-sm btn-warning"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button>
			</td>
			<td width="5%">
				<a href=\"#\" onclick="javascript:exclui_prontuario('.$dados_prontuario['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir
				</a>
			</td>
			</tr>
			<tr '.$classe.'>
			<td align="right"><strong>Clínica:&nbsp; </strong></td>
			<td colspan="3">'.$dados_prontuario['nome_clinica'].'</td>
			</tr>
			<tr '.$classe.'>
			<td align="right" valign="top"><strong>Diagnóstico:&nbsp;</strong></td>
			<td colspan="3" valign="top">'.htmlspecialchars_decode($diago).'</td>
			</tr>
</tr>';

	}		
}
$tabela .='</table></div>';
echo $tabela;
?>