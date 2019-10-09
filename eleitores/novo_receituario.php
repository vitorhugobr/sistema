<?php
include_once("../seguranca.php");
protegePagina();
include_once("../utilitarios/funcoes.php");
date_default_timezone_set('America/Sao_Paulo');
$cod_cadastro = $_GET['cod_cad'];
if (!isset($id)){
	$id = "NULL";
}else{
	$id = "$id";
}
$_SESSION['tab']= 6;

$query = "SELECT * from cadastro WHERE cadastro.CODIGO = $cod_cadastro";
//echo $query;
$mysql_query = $_con->query($query);
if ($mysql_query->num_rows<1) {
	echo '<script>alert("ELEITOR não cadastrado!");</script>';					
}else{
	while ($dados_s = $mysql_query->fetch_assoc()) {
		$nome = $dados_s['NOME'];
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
$_SESSION['tab']=6;
?>

<!-- --------------------------------------------------------------------------------------- -->
<!-- --- paramêtro 1 passado a seguir significa que será incluído - insert  -->
<!-- --------------------------------------------------------------------------------------- -->
<form name="form1" method="post" action="gravar_receituario.php?funcao=1">
<section id="corpo" class="container-fluid">
<input type="hidden" name="id" id="id" value="<?php echo $id?>">
<input type="hidden" name="cod_cadastro" id="cod_cadastro" value="<?php echo $cod_cadastro?>">
  <table class="table-borderless">
     <thead>
     <tr>
      <th colspan="2" class="text-dark text-center"> Receituário para <?php echo $nome?>
    	</th>
    	</tr>
    </thead>
    <tbody> 
    	<tr>
    		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8">
            <label>Data da Receita:</label>
        	</div>
      	</th>
    		<td width="85%"> 
     			<div class="col-3">
					<input type="date" class="form-control" name="data_receita" id="data_receita" required="required" autofocus="autofocus" />
					</div>
  			</td>
  		</tr>
    	<tr>
    		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8">
            <label>Controle Especial:</label>
        	</div>
      	</th>
    		<td width="85%"> 
     			<div class="col-3">
            <select class="form-control" name="controlado" id="controlado">
              <option value="0">Não</option>
              <option value="1">Sim</option>
            </select>
          </div>
  			</td>
  		</tr>
      <tr>
    		<th scope="row" width="15%" align="right"> 
        	<div class="col-12 col-8">
            <label>Tipo de Uso:</label>
        	</div>
      	</th>
   			<td width="85%"> 
          <div class="col-sm-5">
            <select class="form-control" name="tp_uso" id="tp_uso">
                  <option value="0" selected="selected">Interno</option>
                  <option value="1">Externo</option>
            </select>
          </div>
        </td>
  	</tbody>
  </table>
</section>
<div class="col-12 text-center">
  <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-save" aria-hidden="true"></i> Gravar</button>
  <button type="button" class="btn btn-sm btn-dark" onclick="javascript:voltaPag('cadastro.php#tela_receituarios');"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar Cadastro</button>
</div>
</form>

<script type="text/javascript" src="../ckeditor/styles.js"></script>
<script type="text/javascript" src="../js/eleitor.js"></script>
<script src="../js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<?php include_once("../utilitarios/rodape-fixo.php");?>
</body>
</html>
