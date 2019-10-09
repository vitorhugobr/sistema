<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$query = "SELECT * from visitas WHERE Visitante = ".$_GET['cod']." order by DataDaVisita desc";
//echo "<span class='textoAzul'>".$_GET['nome']."</span>";

$mysql_query = $_con->query($query);
$visitas=0;
if ($mysql_query->num_rows>0) {
	$dadosvisita = '<div class="container-fluid">
		<div class="row">
			<div class="col-2"><strong>Data da Visita</strong></div>
			<div class="col-8"><strong>Assunto</strong></div>
		</div>';	
	$corbg = 1;
	while ($dados_visitas = $mysql_query->fetch_assoc()) {
		if ($corbg == 1){
			$colorbg = "bg-light";
			$corbg = 0;
		}else{
			$colorbg = "bg-white";
			$corbg = 1;
		}
		$dadosvisita .= '<div class="row '.$colorbg.'">
							<div class="col-2">'.FormatDateTime($dados_visitas["DataDaVisita"],7).'</div>
							<div class="col-8">'.$dados_visitas["Assunto"].'</div>
							<div class="col-2"><button type="button" class="btn btn-sm btn-danger" 	onClick="exclui_visita('.$dados_visitas["Visita"].')"><i class="fas fa-trash"></i> Excluir</button>
							</div>
						</div>';
		$visitas .= FormatDateTime($dados_visitas["DataDaVisita"],7)." - ".$dados_visitas["Assunto"].'\n';
	}
	$dadosvisita .= '</div>';
	echo $dadosvisita;
	// txtVisitas é do tipo hidden e serve para imprimir a ficha do eleitor		
}else{
	echo "Sem contatos";
}
?>