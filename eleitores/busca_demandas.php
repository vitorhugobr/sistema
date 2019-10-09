<?php
// fazer a leitura dos encaminhamentos e tb dos históricos
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
$query = "SELECT * from encaminhamentos_view WHERE codigo = ".$_GET['cod']." order by data desc";
$mysql_query = $_con->query($query);
$problemas=0;

if ($mysql_query->num_rows>0) {
	while ($dados_demandas = $mysql_query->fetch_assoc()) {
		$numero = $dados_demandas['numero'];
		$situacao = $dados_demandas['situacao'];
		//echo $situacao."<br>";
		switch($situacao) {				
		  case 0:
			$temresposta= '<font color="#00CC33"><strong>Sem NENHUMA resposta</strong></font>';
			break;
		  case 1:	
			$temresposta= '<font color="#0000FF"><strong>Aberta</strong></font>';
			break;
		  case 2:
			$temresposta= '<font color="#FF6633"><strong>Encerrada</strong></font>';
			break;
		  default:			
			  break;
		}

		$dadosproblemas = '<table class="table table-sm table-hover">
							  <tr class="table-info">
								  <td width="20%"><strong>Data:&nbsp;<font color="#0000CC">'.FormatDateTime($dados_demandas["data"],7).'</font></strong></td>
								  <td width="60%"><strong>Assunto:&nbsp;</strong>
								  '.$dados_demandas["assunto"].' </td>
								  <td width="20"><strong>Situação:&nbsp;</strong>'.$temresposta.'</td>
							  </tr>
							  <tr class = "success">
								  <td colspan="3">'.$dados_demandas["descricao"].'</td>
							  </tr>
						  </table>';
		echo $dadosproblemas;
		$query2 = "SELECT * from historico_encaminhamentos WHERE numero = ".$numero." order by data desc";
		$mysql_query2 = $_con->query($query2);
		if ($mysql_query2->num_rows>0) {
			$qtderesp=TRUE;
			$dadosproblemas = '<table class="table-sm table_striped">';
			while ($dados_demandas = $mysql_query2->fetch_assoc()) {
				$dadosproblemas .= '<tr class = "active">    
									  <td width="20%"><label>Em&nbsp;</label>'.FormatDateTime($dados_demandas["data"],7).'
									  </td>    
									  <td width="70%">'.$dados_demandas['retorno'].' 
									  </td>
									  <td width="10%"><label>&nbsp;por&nbsp;</label>'.$dados_demandas['usuario'].'
									  </td> 
									</tr> ';
			}
			$dadosproblemas .= '</table> <hr />';
			echo $dadosproblemas;

		}
	}
}else{
	echo "<p><span class='textoVerde'>Sem Demandas</span></p>";
}

?>