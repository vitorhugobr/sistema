<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
$_SESSION['funcao']="Contatos/Visitas";
$cod = $_GET['cod'];
$nome = $_GET['nome'];
$_SESSION['tab']= 3;

?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Cadastro de Visitas/Contatos">
	<meta name="author" content="Vitor H M Oliveira">
	<script language="javascript" src="../js/visitas.js"></script>
	<script src="../js/carrega_ajax.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script src="../js/ie-emulation-modes-warning.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
  	<script src="../js/ie10-viewport-bug-workaround.js"></script>
	<link rel="icon" href="../imagens/favicon.ico">
	<link href="../css/formata_textos.css" rel="stylesheet">
  	<link href="../css/all.css" rel="stylesheet">
  	<link href="../css/botoes.css" rel="stylesheet">
	<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include_once("../utilitarios/cabecalho.php");  ?>
<form id="visitas" name="visitas" method="post" action="">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="8%" align="right"><label>Nome: </label></td>
    <td colspan="2">
      <div class="col-sm-12">
        <input name="txtcodigo" type="hidden" id="txtcodigo" value="<?php echo $cod;?>">
        <?php echo " ".$nome; ?>
      </div>
    </td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">
    	<label>Data:</label>
    </td>
    <td width="20%">
    <div class="col-sm-12">
				<input type="date" class="form-control" name="txtdata" id="txtdata" placeholder="00/00/0000" autofocus="autofocus">
    </div>
    <td width="53%">
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" align="right">
    	<label>Assunto:</label>
    </td>
    <td colspan="3" valign="top">
	    <div class="col-sm-12">
    		<textarea class="form-control" name="txtassunto" cols="120" rows="6" id="txtassunto" onChange="javascript:this.value=this.value.toUpperCase();" ></textarea>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" valign="top">
    	<div align="center">
        <button type="button" class="btn btn-sm btn-incluir" onclick="javascript:grava_visita();">
          <i class="fas fa-plus" aria-hidden="true"></i> Incluir
        </button>
        <button type="button" class="btn btn-sm btn-cancelar" data-dismiss="modal" onClick="self.window.close();"><i class="fas fa-window-close"></i> Cancelar
        </button>
    	</div>
    </td>
  </tr>
</table>
</form>
<?php 
include_once("../utilitarios/rodape.php");
?>
</body>
</html>
