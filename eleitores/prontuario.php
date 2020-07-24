<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
$id = $_GET['id'];
$_SESSION['tab']= 5;

if (isset($id)){
	$query = "SELECT * from prontuario_view WHERE id = $id";
//		echo $query;
	$mysql_query = $_con->query($query);
	if ($mysql_query->num_rows<1) {
		echo '<script>alert("ERRO ao ler prontuario!");</script>';					
	}else{
		while ($dados_s = $mysql_query->fetch_assoc()) {
			$cod_cadastro = $dados_s['cod_cadastro'];
			$nome = $dados_s['nome'];
			$data_consulta = FormatDateTime($dados_s['data_consulta'],7);
			$clinica = $dados_s['cod_clinica'];
			$diagnostico = $dados_s['diagnostico'];
			$prioridade = $dados_s['prioridade'];
//		0-normal 1-baixa 2-media- 3-alta
			switch ($prioridade) {
				case 0:
					$prio = "Normal";
				case 1:	
					$prio = "Baixa";
				case 2:
					$prio = "Média";
				case 3:
					$prio = "Alta";
			}
		}
	}
}
$_SESSION['funcao']="Prontuário";
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Prontuarios">
<meta name="author" content="Vitor H M Oliveira">
<title>Prontuário <?php echo $nome ?></title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href="../css/all.css" rel="stylesheet">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" role="document">
<?php include_once("../utilitarios/cabecalho.php");?>
<!-- --------------------------------------------------------------------------------------- -->
 <?php

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
$_SESSION['tab']=5;
?>
<form name="form1" method="post" action="gravar_prontuario.php">

<section id="corpo" class="container-fluid">
<input type="hidden" name="id_prontuario" id="id_prontuario" value="<?php echo $id?>">
<input type="hidden" name="cod_cadastro" id="cod_cadastro" value="<?php echo $cod_cadastro?>">
  <table class="table-borderless">
     <thead>
     <tr>
      <th colspan="2" class="text-dark text-center">Prontuário de <?php echo $nome;?></div>
    	</th>
    	</tr>
    </thead>
    <tbody> 
    	<tr>
    		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8">
            <label>Data da Consulta:</label>
        	</div>
      	</th>
    		<td width="85%"> 
     			<div class="col-3">
						<input type="datetime" class="form-control" name="data_consulta" id="data_consulta" value="<?php echo $data_consulta?>">
					</div>
  			</td>
  		</tr>
    	<tr>
    		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8">
            <label>Clínica da Consulta:</label>
        	</div>
      	</th>
    		<td width="85%">
   			<div class="col-sm-10 col-md-8"> 
          <select class="form-control" name="cod_clinica" id="cod_clinica">
            <option>Selecione</option>
            <?php
              $sql = "select * from clinicas order by clinica";
              $mysql_query = $_con->query($sql);
              if ($mysql_query->num_rows>0) {
                while ($_row = $mysql_query->fetch_assoc()) {
                	if ($clinica==$_row['id']){?>
                  	<option value="<?php echo $_row['id']; ?>" selected="selected"><?php echo $_row['clinica']; ?></option>
              <?php
									}else{?>
                  	<option value="<?php echo $_row['id']; ?>"><?php echo $_row['clinica']; ?></option>
               <?php 
									}
                }
              }?>
          </select>
        </div>
  			</td>
  		</tr>
    	<tr>
    		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8">
            <label>Prioridade:</label>
        	</div>
      	</th>
    		<td width="85%"> 
     			<div class="col-3">
						<input type="text" class="form-control" name="priority" id="priority" disabled="disabled" value="<?php echo $prio?>">
						<input type="hidden" class="form-control" name="prioridade" id="prioridade" value="<?php echo $prioridade?>">
					</div>
  			</td>
  		</tr>
    	<tr>
    		<th scope="row" width="15%" align="right" valign="top"> 
        	<div class="col-12 col-8">
            <label>Diagnóstico:</label>
        	</div>
      	</th>
    		<td width="85%"> 
     			<div class="col-12">
          	<textarea name="diagnostic" class="ckeditor" cols="180" rows="20"  id="diagnostic"><?php echo $diagnostico?></textarea>
						<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
            <script type="text/javascript">
                CKEDITOR.replace( 'diagnostic' );
            </script>					
          </div>
  			</td>
  		</tr>
  	</tbody>
  </table>
</section>
<div class="col-12 text-center">
  <button type="submit" class="btn btn-sm btn-success">
    <i class="fas fa-save" aria-hidden="true"></i> Gravar
  </button>
  <button type="button" class="btn btn-sm btn-voltar" onclick="javascript:voltaPag('cadastro.php?codigo=0');">
    <i class="fas fa-arrow-left" aria-hidden="true"></i> Cadastro
  </button>
</div>
</form>
<script type="text/javascript" src="../ckeditor/styles.js"></script>
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
