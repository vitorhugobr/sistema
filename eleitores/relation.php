<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');
$_SESSION['funcao']="Relações";
$cod = $_GET['cod'];
$nome = $_GET['nome'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de árbitros">
<meta name="author" content="Vitor H M Oliveira">
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<script language="javascript" src="../js/carrega_ajax.js"></script>
<script language="javascript" src="../js/relation.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include_once("../utilitarios/cabecalho.php"); ?>
<div id="carregando"></div>

<form id="relations" name="relations" method="post" action="">
<table class="table table-condensed">
  <tr valign="middle">
    <td align="right">
    	<label>C&oacute;digo:</label>
    </td>
    <td colspan="2" class="textoAzul">
    	<div class="col-sm-2">
     		<input name="txtcodigo" class="form-control" disabled="disabled" type="hidden" id="txtcodigo" value="<?php echo $cod;?>"> 
        <?php echo $cod;?>
			</div>
      <div class="col-sm-8">
			<?php echo $nome; ?></div>
      </td>
    <td width="27%" >
    </td>
  </tr>
  <tr valign="middle">
    <td valign="top" align="right">
    	<label>Nome:</label>
    </td>
    <td width="56%">
    	<input name="txtnomeson" type="text" id="txtnomeson" class="form-control" size="50" maxlength="50" onChange="javascript:this.value=this.value.toUpperCase();"> 
    	<input name="txtson" type="text" disabled id="txtson">
    </td>
    <td width="9%" align="right">
    	<label for="txttipo">Tipo:</label>
    </td>
    <td valign="top" >
      <select name="txttipo" id="txttipo" class="form-control">
        <option value="0" selected></option>
        <option value="1">Pai/M&atilde;e</option>
        <option value="2">Filho(a)</option>
        <option value="3">Sobrinho(a)</option>
        <option value="4">Esposo(a)</option>
        <option value="5">Av&ocirc;(&oacute;)</option>
        <option value="6">Irm&atilde;o(&atilde;)</option>
        <option value="7">Tio(a)</option>
        <option value="8">Neto(a)</option>
        <option value="9">Outro(a)</option>
    	</select>
    </td>
  </tr>
  <tr>
    <td colspan="4"><div align="center">
   	<img src="../imagens/grava.png" width="80" height="26" border="0" onClick="grava_relation()">&nbsp;
   	<img src="../imagens/cancelar.png" width="80" height="26" border="0" onClick="self.window.close()">
    </div></td>
  </tr>
</table>
</form>
<script type="text/javascript">
    new Autocomplete("txtnomeson", function() { return "autocomplete_nome.php?typing=" + this.text.value;});
</script>
<?php include_once("../utilitarios/rodape.php"); ?>
</body>
</html>
