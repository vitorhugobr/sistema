<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');
if ($_SESSION['usuarioCodigo']>1){
	alert('Não vai buscar exames');
	return;
}
$query = "SELECT * from exames_view WHERE cod_cadastro = ".$_GET['cod']." order by id desc, data desc";
$mysql_query = $_con->query($query);
$qtderegs = $mysql_query->num_rows;
$tabela_exames = '<div class="table-responsive container-fluid"><table class="table-striped">
	<tr>
		<td colspan="5">
			<button type="button" onclick="javascript:inclui_exames('.$_GET["cod"].')" class="btn btn-sm btn-primary"><i class="fas fa-plus" aria-hidden="true"></i> Novo Exame </button>		
		</td>
	</tr>';
if ($qtderegs ==0) {
	$tabela_exames .= '<tr><td><strong>SEM EXAMES CADASTRADIS</strong></td></tr>';
}else{
	$linha = 1;
	$id_anterior = 0;
	while ($dados_exames = $mysql_query->fetch_assoc()) {
		$anohj = substr($dados_exames["data"],0,4);
		$meshj = substr($dados_exames["data"],5,2);
		$diahj = substr($dados_exames["data"],8,2);
		//echo $anohj." ".$meshj." ".$diahj."<br>"; 
		$arquivo = "../imagens/exames/".str_pad($dados_exames['cod_cadastro'],6,"0",STR_PAD_LEFT).$anohj.$meshj.$diahj.str_pad($dados_exames['cod_exame'],3,"0",STR_PAD_LEFT).str_pad($dados_exames['id'],3,"0",STR_PAD_LEFT).".jpg";
		if (file_exists($arquivo)) {
//			echo $arquivo."<br>";
			$habilita_ver_imagem = true;	
		} else {
			$habilita_ver_imagem = false;	
		}		
		if ($dados_exames["id"]==$id_anterior){
			$tabela_exames .='<tr '.$classe.'>
				<td align="right" width="10%"></td>
				<td colspan="2" width="85%">'.$dados_exames["descricao"].'</td>
				<td width="10%">';
			if ($habilita_ver_imagem){	
					$tabela_exames .= '<a href="#" onclick="javascript:ver_exame_solicitado('.$dados_exames['cod_cadastro'].','.$anohj.$meshj.$diahj.','.$dados_exames['cod_exame'].','.$dados_exames['id'].')" class="btn btn-sm btn-warning btn-block" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame 
					</a>';
			}
			$tabela_exames .= '</td>
				<td width="10%">
					<a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:exclui_exame_solicitado('.$dados_exames['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir Item
					</a>
				</td>
				</tr>';
		}else{
			if ($linha == 1) {
				$classe = 'class="bg-light"';
				$linha =2;
			}else {
				$classe = 'class="bg-white"';
				$linha =1;
			}
			$tabela_exames .='<tr '.$classe.'>
				<td align="right" width="10%"><strong>Data:&nbsp;</strong></td>
				<td width="20%" class="text-primary"><strong>'.FormatDateTime($dados_exames["data"],7).'</strong></td>
				<td width="50%" class="text-secondary">#'.$dados_exames["id"].'</td>
				<td width="10%">
					<a href="#" title="Excluir TODOS Exames Solitados" onclick="javascript:exclui_exame('.$dados_exames['id'].')" class="btn btn-sm btn-warning btn-block" /><i class="fas fa-notes-medical" aria-hidden="true"></i> Excluir Solicitação
					</a>
				</td>
				<td width="10%">
					<a href="#" title="Imprimir Solicitação do exame" onclick="javascript:imprime_exames('.$dados_exames['cod_cadastro'].','.$dados_exames['id'].')" class="btn btn-sm btn-info btn-block" /><i class="fas fa-print" aria-hidden="true"></i> Imprimir
					</a>
				</td>
				</tr>
				<tr '.$classe.'>
				<td width="10%" align="right"><strong>Exame:&nbsp;</strong></td>
				<td colspan="2" width="70%">'.$dados_exames['descricao'].'</td>
				<td width="10%">';
			if ($habilita_ver_imagem){	
					$tabela_exames .= '<a href="#" onclick="javascript:ver_exame_solicitado('.$dados_exames['cod_cadastro'].','.$anohj.$meshj.$diahj.','.$dados_exames['cod_exame'].','.$dados_exames['id'].')" class="btn btn-sm btn-warning btn-block" /><i class="fas fa-x-ray" aria-hidden="true"></i> Ver Exame 
					</a>';
			}
			$tabela_exames .= '</td>
				<td width="10%">
					<a href="#" title="Excluir o exame '.$dados_exames["descricao"].'" onclick="javascript:exclui_exame_solicitado('.$dados_exames['id'].')" class="btn btn-sm btn-danger btn-block" /><i class="fas fa-trash" aria-hidden="true"></i> Excluir Item
					</a>
				</td>
				</tr>';
		}
		$id_anterior = $dados_exames["id"];

	}		
}
$tabela_exames .='</table></div>';
echo $tabela_exames;
?>



