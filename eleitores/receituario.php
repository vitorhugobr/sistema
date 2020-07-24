<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
$id = $_GET['id'];
$_SESSION['tab']= 6;

if (isset($id)){
	$query = "SELECT * from receituario_view WHERE id = ".$id;
	//echo $query;
	$mysql_query = $_con->query($query);
	if ($mysql_query->num_rows<1) {
		echo '<script>alert("ERRO ao ler prontuario!");</script>';					
	}else{
		while ($dados_s = $mysql_query->fetch_assoc()) {
			$cod_cadastro = $dados_s['cod_cadastro'];
			$nome = $dados_s['nome'];
			$data = FormatDateTime($dados_s['data'],7);
			$controle = $dados_s['controlado'];
			$tp_uso = $dados_s['tp_uso'];
		}
	}
}
$_SESSION['funcao']="Receituário";
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Receituarios">
<meta name="author" content="Vitor H M Oliveira">
<title>Receituário <?php echo $nome ?></title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href="../css/botoes.css" rel="stylesheet">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document">
<?php include_once("../utilitarios/cabecalho.php");?>
 <?php

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<!-- --------------------------------------------------------------------------------------- -->
<!-- --- paramêtro 0 passado a seguir significa que será alteração - update  -->

<form name="form1" method="post" action="gravar_receituario.php?funcao=0">
<section id="corpo" class="container-fluid">
<input type="hidden" name="id_receituario" id="id_receituario" value="<?php echo $id?>">
<input type="hidden" name="cod_cadastro" id="cod_cadastro" value="<?php echo $cod_cadastro?>">
<div class="col-12 text-center">
  <button type="submit" class="btn btn-sm btn-success">
    <i class="fas fa-save" aria-hidden="true"></i> Gravar Dados Receita
  </button>
  <button type="button" class="btn btn-sm btn-voltar" onclick="javascript:voltaPag('cadastro.php?codigo=0');">
    <i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar Cadastro
  </button>
</div>
  <table class="table-borderless container-fluid">
     <thead>
     <tr>
      <th colspan="4" class="text-monospace text-dark text-center"> Receituário de 
      	<div class="text-monospace text-center text-uppercase badge-info rounded">
					<?php echo $nome?>
        </div>
        <div id="divCheckbox" style="display: none;"><?php echo $nome?></div>
    	</th>
    </tr>
    <tr>
    	<th colspan="4"  class="text-monospace text-dark text-left">
        	Dados da Receita
        </th>
    </tr>
    </thead>
    <tbody> 
    	<tr>
          <th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8 text-right" >
            <label>Data da Receita:</label>
        	</div>
          </th>
    		<td colspan="3" width="85%"> 
     			<div class="col-3">
					<input type="datetime" class="form-control" name="data_receita" id="data_receita" value="<?php echo $data?>">
				</div>
  			</td>
  		</tr>
    	<tr>
          <th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8 text-right">
            <label>Controle Especial:</label>
        	</div>
          </th>
    		<th colspan="3" width="85%"> 
     			<div class="col-3">
            	<select class="form-control" name="controlado" id="controlado">
              	<option value="0" <?php if ($controle==0) echo 'selected="selected"'?>>Não</option>
              	<option value="1" <?php if ($controle==1) echo 'selected="selected"'?>>Sim</option>
            	</select>
          		</div>
  			</th>
  		</tr>
      <tr>
     		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8 text-right">
            	<label>Tipo de Uso:</label>
        	</div>
      	</th>
   			<td colspan="3" width="85%"> 
          <div class="col-sm-5">
            <select class="form-control" name="tp_uso" id="tp_uso">
            <?php 
              if ($tp_uso==0){?>
                  <option value="0" selected="selected">Interno</option>
                  <option value="1">Externo</option>
              <?php }else{?>
                  <option value="0">Interno</option>
                  <option value="1" selected="selected">Externo</option>
              <?php }?>
            </select>
          </div>
        </td>
      </tr>
    	<tr>
    	<tr>
    		<th width="5%"> 
      	</th>
    		<th scope="row" width="10%" align="right" valign="top"> 
        	<div class="col-12 col-8">
            <label>Medicamentos:</label>
        	</div>
      	</th>
        <td colspan="2" width="85%" align="right">
        	<div class="col-12">
          	<button type="button" class="btn btn-incluir btn-sm" data-toggle="modal" data-target="#myModalcad"><i class="fas fa-plus"></i> Inserir Medicamento</button>
          </div>
        	<div class="col-12">
          <?php
							$query2 = "SELECT * from dados_receita WHERE cod_receita = ".$id;
              $mysql_query2 = $_con->query($query2);
							$bgcor = 0;
							$classe = 'class="bg-light"';
              if ($mysql_query2->num_rows==0) {
                echo '<div align="left" class="text-excluir"><strong>SEM MEDICAMENTOS NESTA RECEITA</strong></div>';
              }else{
                $linha = 1;
//								echo '<table class="table table-borderless table-sm">';
								$indice = 0;		
                while ($remedios = $mysql_query2->fetch_assoc()) {
									if ($bgcor==0){
										$classe = 'class="bg-light"';
										$bgcor=1;
									}else{
										$classe = 'class="bg-transparent"';
										$bgcor=0;
									}
                  $medicamento = $remedios['medicamento'];
                  $qtde = $remedios['qtde'];
                  $posologia = $remedios['posologia'];
									$parametro = $remedios['id'].','.$medicamento.','.$qtde.','.$posologia;
                  echo  
                     '<tr '.$classe.' class="">
									  <td width="5%">
									  </td>
									  <td width="68%">
										  <div class="col-12" style="border-left:0">
											  <input name="remedio" id="remedio" class="form-control" type="text" value="'.$medicamento.'">
										  </div>
									  </td>
									  <td width="17%" align="left">
										  <div class="col-12">
										   <input name="qtde" id="qtde" type="text" class="form-control" value="'.$qtde.'">
										  </div>
									  </td>
									  <td width="7%" rowspan="2" align="left">
										  <div class="col-12">
											  <button type="button" onclick="gravar_remedio('.$remedios['id'].','.$indice.')" class="btn btn-sm btn-incluir btn-block"><i class="fas fa-edit" aria-hidden="true"></i> Gravar Medicamento</button>
										  </div>
									  </td>
									  <td width="7%" rowspan="2" align="left">
										  <div class="col-12">
											  <button type="button" onclick="javascript:excluir_remedio('.$remedios['id'].')" class="btn btn-sm btn-excluir btn-block"><i class="fas fa-trash" aria-hidden="true"></i> Excluir</button>
										  </div>
									  </td>

									  </tr>
									  <tr '.$classe.'>
									  <td width="5%"></td>
									  <td colspan="4" align="left">
										  <div class="col-8">
											  <input type="text" id="posologia" name="posologia" class="form-control" value="'.$posologia.'">
										  </div>
									  </td>
			  </tr>
									  <tr height="0">
									  <td colspan="5" height="0"><hr style="color: #f00;background-color: #f00;height: 1px;"></td>
								  </tr>';
									$indice++;
                }
								echo '</tr>';
//								</table>';
              }
					?>						
          </div>

        </td>
      </tr>
  	</tbody>
  </table>
</section>
</form>
<!-- Inicio Modal -->
<div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center" id="myModalLabel">Inserir Medicamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <form method="POST" action="incluir_medicamento.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="recipient-name" class="control-label">Medicamento:</label>
            <input name="medicamento" type="text" class="form-control">
            <input name="cod_receita" type="hidden" class="form-control" value="<?php echo $id?>">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Qtde:</label>
            <input name="qtde" type="text" class="form-control" size="10" maxlength="5">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Posologia:</label>
            <input name="posologia" type="text" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-incluir"><i class="fas fa-save"></i> Incluir</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fim Modal -->

<script type="text/javascript" src="../js/eleitor.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<?php include_once("../utilitarios/rodape.php");?>
</body>
</html>
