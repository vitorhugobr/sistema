<?php
include("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$query = "SELECT * from visitas WHERE Visitante = ".$_GET['cod']." order by DataDaVisita desc";
//echo "<span class='textoAzul'>".$_GET['nome']."</span>";

$mysql_query = $_con->query($query);
$visitas=0;
if ($mysql_query->num_rows>0) {
	$dadosvisita = '<table class="table table-striped">
										<tr>
											<th width="9%" valign="top">Data da Visita</th>
											<th width="82%"  valign="top">Assunto</th><th>Opções</th>
										</tr>';
	while ($dado_s = $mysql_query->fetch_assoc()) {
		if ($visitas==0){
			echo "<span class='textoAzul'>".$nome."</span>";
			$visitas=1;
		}
		$dadosvisita .= '<tr>
						<td width="9%" valign="top">
							'.FormatDateTime($dado_s["DataDaVisita"],7).'
						</td>
						<td width="82%"  valign="top">
							'.$dado_s["Assunto"].'
						</td>
						<td width="5%">
							<button type="button" class="btn btn-xs btn-danger" onClick="exclui_visita('.$dado_s["Visita"].')"><i class="fas fa-remove"></i> Excluir</button>
						</td>
						</tr>';
		$visitas .= FormatDateTime($dado_s["DataDaVisita"],7)." - ".$dado_s["Assunto"].'\n';
	}
	$dadosvisita .= '</table>';
	echo $dadosvisita;
	// txtVisitas é do tipo hidden e serve para imprimir a ficha do eleitor		
}else{
	echo "Sem contatos";
}
?>