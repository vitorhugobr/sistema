<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
$ends = '';
$endrel='';
$query = "SELECT * from enderecos_view WHERE codigo = ".$_GET['cod'].' order by padrao desc';
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows>0) {
	while ($dados_endereco = $mysql_query->fetch_assoc()) {
		$id= $dados_endereco["id"];
		$codigo= $dados_endereco["codigo"];
		$cep= $dados_endereco["cep"];
		$cep_ed = substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
		$tipolog= $dados_endereco["tipolog"];
		$rua= $dados_endereco["rua"];
		$bairro= $dados_endereco["bairro"];
		$cidade= $dados_endereco["cidade"];
		$uf= $dados_endereco["uf"];
		$numero= $dados_endereco["numero"];
		$compl = $dados_endereco["complemento"];
		$padrao= $dados_endereco["padrao"];
		if ($padrao=="S"){
			$padrao="SIM";
		}else{
			$padrao= "NÃO";
		}
		$tipo= $dados_endereco["tipo"];			
		$reg= $dados_endereco["reg"];			
		$nome= $dados_endereco["nome"];			
		$endereco = '<i class="fas fa-home" aria-hidden="true"></i>&nbsp'.$tipolog.' '.$rua.', '.$numero.' '.$compl.' '.$cidade.', '.$uf.' - '.$cep_ed.', Brasil';
		$prg= 'enderecos.php?otipo=A&id='.$id;
		if ($tipo=="R"){
			$tipo= "RESIDENCIAL";
		}else{
			$tipo= "OUTRO";
		}
		$ends .='<div class="container-fluid">
					<div class="row">
					<div class="col">
						'.$endereco.'	
					</div>
	  			</div>
				<div class="row">
					<div class="col"><i>CDD: </i>'.$reg.' <i>Tipo: </i>'.$tipo.' <i>Endereço Padrão: </i>'.$padrao.'		
					</div>	
					<div class="col">
					<button type="button" class="btn btn-sm btn-warning" onClick="AlteraEnd(';
						$ends .= "'".$prg."'";
						$ends .= ')";><i class="fas fa-save" aria-hidden="true"></i> Alterar</button>&nbsp;';
						$param = $tipolog.','.$rua.','.$numero.','.$cidade.','.$uf;
						$endereco = $rua.' '.$tipolog.'+'.$rua.',+'.$numero.',+'.$bairro.',+'.$cidade.',+'.$uf;
				//		echo '<a href="https://maps.google.com.br/maps?q='.$endereco.'" target="_blank">VER NO MAPA</a>';
						$ends .= '<button type="button" class="btn btn-sm btn-danger" onClick="Exclui_ender('.$id.')"><i class="fas fa-trash" aria-hidden="true"></i> Excluir</button>&nbsp;<a href="https://maps.google.com.br/maps?q='.$endereco.'" target="_blank" class="btn btn-success btn-sm" role="button" ><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Ver no Google Maps</a>
							</div>
						</div>
					</div>';
			}
	echo $ends;
}else{
	echo '';
}			

// https://www.google.com.br/maps/place/Av.+Bento+Gon%C3%A7alves,+2445+-+Partenon,+Porto+Alegre+-+RS,+90650-002/@-30.0611626,-51.1926825,17z/data=!3m1!4b1!4m5!3m4!1s0x9519780f6d9899c1:0x678c1397c0b787c5!8m2!3d-30.0611626!4d-51.1904938?hl=pt-BR
?>