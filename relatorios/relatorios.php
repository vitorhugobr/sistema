<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once("../utilitarios/funcoes.php");
if (liberado(6100)==0){
	expulsaVisitante2();
}else{
	$_SESSION['funcao']="Relatórios";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Eleitores">
<meta name="author" content="Vitor H M Oliveira">
<title>Relatórios</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/botoes.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-grid.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="../css/docs.min.css"/>
<script language="javascript" src="../js/relatorios.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onFocus="javascript:location.reload();">
<?php include_once("../utilitarios/cabecalho.php");?>
	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>

<form name="form1" method="post" action="monta.php" target="_blank">
  <p align="center">
     <input name="htipo" type="hidden" id="htipo">
     <input name="hopcao" type="hidden" id="hopcao">
	 <a href="../index2.php" class="btn btn-menu btn-sm" role="button">
		  <i class="fas fa-list-ul"></i>  Menu
	  </a>
    <input name="hPV" type="hidden" id="hPV">
  </p>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td height="73" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="0" id="tabelaopcoes">
          <tr>
            <td width="20%" valign="top" nowrap="nowrap">
            	<div class="col-sm12 col-sm-12">
              <fieldset>
                <legend>Tipos de Relatórios</legend>
                <input class="radio-inline" name="tipo" type="radio" value="radiobutton" onClick="mostraGeral()"/>
                Cadastro Geral<br />
                <input class="radio-inline" name="tipo" type="radio" value="radiobutton" onClick="mostraAniver()"/>
                Aniversário
              </fieldset>
              </div>
            </td>
            <td width="31%" valign="top" nowrap="nowrap"><div id="opcGeral"></div></td>
            <td width="49%" valign="top" nowrap="nowrap"><div id="opcAniver"></div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td valign="top">
      	<div id="cabusuarios"></div>
      </td>
    </tr>
  </table>
</form>
<?php
include_once("../utilitarios/rodape-fixo.php");
?>
</body>
</html>
<?php
}
?>