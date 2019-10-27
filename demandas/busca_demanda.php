<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once('../utilitarios/funcoes.php');

$numero = $_GET['numero'];

$query = "SELECT * FROM busca_encaminha WHERE numero = $numero";

$mysql_query = $_con->query($query);
$mostra_demanda="";
if ($mysql_query->num_rows<1) {
	echo '<script>alert("DEMANDA não encontrada!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$codigo = $dados_s["codigo"];
		$num = str_pad($dados_s["numero"], 5, '0', STR_PAD_LEFT);
		$numero = $dados_s["numero"];
		$data = FormatDateTime($dados_s["data"],7);
		//$data = $dados_s["data"];
		$assunto = $dados_s["assunto"];
		$desc = $dados_s["descricao"];
		$situation = $dados_s["situacao"];
		$situacao = $dados_s["situacao"];
		switch($situacao) {				
		  case 0:
			$situacao_img ='<img src="../imagens/naorespondida.png" height="18" />';
			  break;
		  case 1:	
			$situacao_img ='<img src="../imagens/respondida.png" height="18" />';
			  break;
		  case 2:
			$situacao_img ='<img src="../imagens/encerrada.png" height="18" class="rounded-circle"/>';
			  break;
		  case 5:
			$situacao_img ='<img src="../imagens/arquivada.png" height="18"/>';
			  break;
		  default:			
			  break;
		}
		$endereco = $dados_s["endereco"];
		$protocolo = $dados_s["protocolo"];
		$nome = $dados_s["nome"];
		$operador = $dados_s["operador"];
		$temresponsavel = $dados_s["temresponsavel"];
		$tarefa_enc = $dados_s["tarefa"];
		//echo "tarefa: ".$tarefa_enc."<br>";
		$_SESSION['codigo_requerente'] = $codigo;	
		// BUSCAR FOTOS DA DEMANDA
		$qtdefotos = 0;
		$teste="";
		$arqbuscapdf =  "D".str_pad($dados_s["numero"], 7, '0', STR_PAD_LEFT).'000';
		$arquivopdf = "../imagens/demandas/".$arqbuscapdf.".pdf";
		$urlpdf="Nenhum PDF vinculado à Demanda";
		$tempdf = false;
		if (file_exists($arquivopdf)) {
			//$imagens .= '<img class="img-fluid" src="'.$arquivo.'" alt="Foto da demanda">';
			$urlpdf = '<a href="'.$arquivopdf.'" target="_blank"><img src="../imagens/pdf.png"></a>';
			$tempdf = true;
		} 	

		$array_fotos = array();
		$imagens ='<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
					  <div class="carousel-inner">';
		for ($i=0; $i < 1000; $i++) {
			$arqbusca =  "D".str_pad($dados_s["numero"], 7, '0', STR_PAD_LEFT).str_pad($i, 3, '0', STR_PAD_LEFT);
			$arquivo = "../imagens/demandas/".$arqbusca.".jpg";
			if (file_exists($arquivo)) {
				$qtdefotos++;
				$array_fotos[] = $arquivo;
				if ($qtdefotos==1){
					$imagens .= '<div class="carousel-item active">';
				}else{
					$imagens .= '<div class="carousel-item">';
				}
				//$imagens .= '<img class="img-fluid" src="'.$arquivo.'" alt="Foto da demanda">';
				$imagens .= ' <img src="'.$arquivo.'" alt="Demanda" class="carousel container slide"/>';
				$imagens .= '</div>';
				$seq = $qtdefotos;
			} 	
		}			 
					
		$imagens .='</div><a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Anterior</span>
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Próximo</span>
					  </a>
					</div>';
				
		if ($qtdefotos==0){
			$seq = 0;
			$imagens = "SEM IMAGENS";
		}
		$mostra_demanda .= '
			<table class="table table-sm table-borderless">
				<tr>
					<td width="60%">
						<div class="row">
							<div class="col-3 text-right"><strong>Demanda:</strong></div>
							<div class="col-2 text-left"><strong>'.$num.'</strong>
								<input type="hidden" value="'.$numero.'" id="numero" name="numero">
							</div>
							<div class="col-2 text-right"><strong>Situação:</strong></div>
							<div class="col-2 text-left">'.$situacao_img.'</div>		
						</div>
						<div class="row">
							<div class="col-3 text-right"><strong>Nome:</strong></div>
							<div class="col-6 text-left">';
								if ($_SESSION["usuarioNivel"]==9){
									$mostra_demanda .= '<input type="text" name="txtcodigo_alt" value='.$codigo.'>';
									 $codigo;
								}else{
									$mostra_demanda .= '<input class="form-control" name="txtnome_alt" type="text" size="50" maxlength="50" value="'.$nome.'" autofocus required>';
									$mostra_demanda .= '<input type="hidden" name="txtcodigo_alt" id="txtcodigo_alt" value='.$codigo.'>';
								};
		$mostra_demanda .='</div>
						</div>
						<div class="row">
							<div class="col-3 text-right"><strong>Data:</strong></div>
							<div class="col-3 text-left"><input class="form-control" type="datatime" name="txtdata_dem" id="txtdata_dem" value='.$data.'></div>
						</div>
						<div class="row">
							<div class="col-3 text-right"><strong>Endereço Demanda:</strong></div>
							<div class="col-6 text-left">';
		$mostra_demanda .= '<input class="form-control" name="txtendereco" type="text" size="80" maxlength="100" value="'.$endereco.'" placeholder="Informe endereço da demanda, se necessário. (até 100 caracteres)">';
		$mostra_demanda .= '</div></div>
						<div class="row">
							<div class="col-3 text-right"><strong>Secretaria:</strong></div>
							<div class="col-6 text-left">
						<select name="txtassunto" class="form-control" value="'.$assunto.'">';
						$sql = "select * from secretarias order by descricao";
						$mysql_query = $_con->query($sql);
						if ($mysql_query->num_rows>0) {
							while ($_row = $mysql_query->fetch_assoc()) {
								if ($_row['codigo']==$assunto){ 
								$mostra_demanda .='<option value="'.$_row['codigo'].'" selected="selected">'.$_row['descricao'].'</option>';
								}else{ 
								$mostra_demanda .='<option value="'.$_row['codigo'].'">'.$_row['descricao'].'</option>';
								}
							}
						}

		$mostra_demanda .= '</select></div>
						</div>	
						<div class="row">
							<div class="col-3 text-right"><strong>Protocolo:</strong></div>
							<div class="col-4 text-left">
		    			<input class="form-control" name="txtprotocolo" id="txtprotocolo" value="'.$protocolo.'">		
						</div>
						</div>	
						<div class="row">
							<div class="col-3 text-right"><strong>Descrição:</strong></div>
							<div class="col-9 text-left">
							<textarea class="form-control" name="txtdescricao" cols="80" rows="3" id="txtdescricao">'.$desc.'</textarea>
							</div>
						</div>	
						<div class="row">
							<div class="col-3 text-right"><strong>Gerou a demanda:</strong></div>
							<div class="col-2 text-left">'.$operador.'
							</div>
						</div>	
						<div class="row">
							<div class="col-3 text-right"><strong>Gerou Tarefa:</strong></div>
							<div class="col-2 text-left">';
		if ($tarefa_enc==0){
			$mostra_demanda .= 'NÃO';
		}else{
			$mostra_demanda .= 'SIM';
		}
		$mostra_demanda .= '</div>
							<div class="col-3 text-left">';
		if ($tarefa_enc>0){
			$mostra_demanda .= '<strong>Tarefa:</strong> '.$tarefa_enc.'<input type="hidden" name="txttarefa" id="txttarefa" value="'.$tarefa_enc.'">';
		}
		$mostra_demanda .= '</div>	

					</td>
					<td width="20%" valign="top" height="150px" align="center">
							<div class="col">';
		if ($situacao<2){
			$mostra_demanda .= '<button type="button" class="btn btn-sm btn-upload" onclick="incluir_documento('.$numero.')">
                        <i class="fas fa-upload"></i> Upload Documento
                        		</button><br>';
								
		}
		$mostra_demanda .= $urlpdf.'</td>
					<td width="20%" valign="top" align="center">
							<div class="col">';
		if ($qtdefotos>0){
			 if ($situacao<2){
				$mostra_demanda .= '<button type="button" class="btn btn-sm btn-excluir" onclick="excluir_imagem('.$numero.')">
                        <i class="fas fa-trash"></i> Excluir Imagens
                        		</button> ';
			 }
		}
		if ($situacao<2){
			$mostra_demanda .= '<button type="button" class="btn btn-sm btn-upload" onclick="incluir_imagem('.$numero.','.$seq.')">
                        <i class="fas fa-images"></i> Upload Imagens
                        		</button><br>';
		}
		$mostra_demanda .= $imagens.'</td>
				</tr>	
			</table>';
		
	}
}		

$query = "SELECT * from `historico_encaminhamentos` WHERE numero = ".$numero." order by data desc";
//echo "<br><br><br><br>".$query;
$mysql_query = $_con->query($query);
$nroresp = $mysql_query->num_rows;
if ($mysql_query->num_rows<1) {
	$history = '<div class="alert-warning text-center">Esta DEMANDA não possui resposta!</div>';					
}else{
	$history = '<table class="table table-sm table-striped">';
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$datah = FormatDateTime($dados_s["data"],8);
		$id = $dados_s["id"];
		$numero_h = $dados_s["numero"];
		$retorno = $dados_s["retorno"];		
		$usuario = $dados_s["usuario"];	
		$strdata_user = $datah." por ".$usuario;
		$history .= '<tr>';
		$history .= '<td width="10%" align="right"><strong>Data:</strong></td>';
		$history .=	'<td width="60%" align="left">'.$strdata_user.'</td>';
		$history .=	'<td>';
		if ($situacao<2){
			$history .='<button type="button" class="btn btn-sm btn-excluir" onclick="excluir_resposta('.$id.')"><i class="fas fa-trash"></i> Excluir';
		}
		$history .= '</td>';
		$history .= '</tr>';
		$history .= '<tr>';
		$history .= '<td align="right">Resposta:</td>';
		$history .= '<td colspan="2">'.$retorno.'</td>';
		$history .= '</tr>';
	}
	$history .= '</table>';
}		


$_SESSION['funcao']="Demanda # ".$numero;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Demandas</title>	
<link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
<link rel="SHORTCUT ICON" href="../imagens/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link href="../css/all.css" rel="stylesheet">
<link href="../css/botoes.css" rel="stylesheet">

<style type="text/css">


.narrow {
  width: 100px;
  height: 2000px;
  margin-top: 10px;
}

.fill {
  object-fit: fill;
}

.contain {
  object-fit: contain;
}

.cover {
  object-fit: cover;
}

.none {
  object-fit: none;
}

.scale-down {
  object-fit: scale-down;
}
	</style>
<script src="../js/demandas.js"></script>
<script src="../js/ajax.js"></script>
<script src="../js/carrega_ajax.js"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/autocomplete.js"></script>
<script src="../js/jquery.min.js"></script>
 <script language="javascript">
  	function alterar(){
		//alert('stop');
		var dados  = 'altera_demanda.php?numero='+document.form2.numero.value;
		dados += '&codigo='+document.form2.txtcodigo_alt.value;
		dados += '&assunto='+document.form2.txtassunto.value;
		dados += '&protocolo='+document.form2.txtprotocolo.value;
		dados += '&descricao='+document.form2.txtdescricao.value;
		dados += '&endereco='+document.form2.txtendereco.value;
		if (confirm("Confirma a Alteração da demanda?")){
			ajax2(dados, 'carregando');
			//fechaJanela();
		}
  	}
  
  	function fechaJanela(){
    	self.close();
  	}

	</script>
</head>
<body onFocus="javascript:location.reload();">
 <?php include_once("../utilitarios/cabecalho.php");?>

  	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
 <form class="form-inline" name="form2" method="post" action="">

  <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
  	<div class="container">
    	<span class="navbar-brand">
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        	<ul class="navbar-nav mr-auto">
			  <?php 
              if (liberado(2006)>0){  
				 if ($situacao<2){
					  echo '<li class="nav-item active">
          				<button type="button" class="btn btn-sm btn-incluir" data-toggle="modal" data-target="#incModal">
                        <i class="fas fa-plus"></i> Responder
                        </button>
                    	</li>';
				}
                if ($situacao<2){
					if (liberado(2002)>0){
						echo '<li class="nav-item active">
								<button type="button" class="btn btn-sm btn-success" onClick="alterar()"><i class="fas fa-save"></i> Alterar
								</button>
							</li>';
					}   
				  	echo '<li class="nav-item active">
          				<button type="button" class="btn btn-sm btn-encerrar" onclick="javascript:encerra_encaminhamento('.$numero.')">
                        <i class="fas fa-grin-alt"></i> Encerrar
                        </button>
                    </li>';
	                echo '<li class="nav-item active">
          				<button type="button" class="btn btn-sm btn-imprimir" onclick="javascript:print_demanda('.$numero.')">
                        <i class="fas fa-grin-alt"></i> Imprimir
                        </button>
                    </li>';
				}
				if ($situacao==2) {
	                echo '<li class="nav-item active">
          				<button type="button" class="btn btn-sm btn-cancelar" onclick="javascript:arquiva_encaminhamento('.$numero.')">
                        <i class="fas fa-grin-alt"></i> Arquivar
                        </button>&nbsp;
                    </li>';					
				}
              }
              ?>
              <li class="nav-item">
                  <a href="demandas.php" class="btn btn-voltar btn-sm" role="button">
                      <i class="fas fa-arrow-left" aria-hidden="true"></i>  Voltar
                  </a>
              </li>
              <li class="nav-item">
                  &nbsp;<a href="../index2.php" class="btn btn-menu btn-sm" role="button">
                      <i class="fas fa-list-ul" aria-hidden="true"></i>  Menu
                  </a>
              </li>
          </ul>
      </div>
   	</div>
   </nav>


<div class="container-fluid">
	<div id="mostraE"><?php echo $mostra_demanda?></div>
    <div class="col-12 text-white text-center bg-dark"><strong>Respostas</strong></div>
	<div style="width:100%; height: 370px; overflow: auto;">
		<?php echo $history; ?>
    </div>
</div>
</form>

<!-- modal para inclusão -->
<div class="modal fade" id="incModal" tabindex="-1" role="dialog" aria-labelledby="incModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
          <div class="modal-header">
        	<h4 class="modal-title" id="incModalLabel">Inclusão de Resposta - Demanda <?php echo $numero;?></h4>
        	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
          </div>
        <div class="modal-body">
          <form name="form1" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label for="message-text" class="control-label">Resposta</label>
              <textarea name="retorno" class="form-control" id="retorno" autofocus></textarea>
            </div>
            <div class="form-check">
    			<input type="checkbox" class="form-check-input" id="enviar_email" name="enviar_email">
    			<label class="form-control form-check" for="exampleCheck1">Enviar E-mail ao Solicitande da Demanda.</label>
  			</div>
            <div class="form-group">
              <label for="message-text" class="control-label">CC e-mail</label>
              <input type="email" class="form-control" id="ccemail" name="ccemail" placeholder="Informe outro e-mail para receber resposta">
            </div>
            <input type="hidden" value="<?php echo $numero;?>" id="numero">
            <input type="hidden" value="<?php echo $tarefa_enc;?>" id="num_tarefa" name="num_tarefa">
            <input type="hidden" value="<?php echo $data;?>" id="data_demanda" name="data_demanda">
            <div id="inserir"></div>
            <button type="button" class="btn btn-cancelar" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            <button type="button" class="btn btn-incluir" onClick="grava_Resposta()"><i class="fas fa-save"></i> Gravar</button>
          </form>
        </div>
      </div>
  </div>
</div>


<?php
	include_once("../utilitarios/rodape-fixo.php");
	?>
	  <script type="text/javascript">
		new Autocomplete("txtnome_alt", function() { return "autocomplete_demanda_alt.php?typing=" + this.text.value ;});
	</script>

</body>
</html>
