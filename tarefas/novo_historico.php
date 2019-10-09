<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');

$tarefa = $_GET['task'];
$_SESSION['funcao'] = "Tarefas - Novo Histórico";
$dttarefa = new DateTime();
$dttarefa = $dttarefa->format( "d/m/Y H:i" );
//$dttarefa = date_format(DateTime(), 'd/m/Y H:i:s');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cadastro de Eleitores">
<meta name="author" content="Vitor H M Oliveira">
<title>Tarefas</title>
<link rel="icon" href="../imagens/favicon.ico">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css"/>
<link href="../css/botoes.css" rel="stylesheet">
<script language="javascript" src="../js/tarefas.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
include("../utilitarios/cabecalho.php");
?>
	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>

<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="11%" align="right"><label># Tarefa:</label></td>
    <td width="23%" valign="middle">
    	<div class="col col-sm-6">
			<span class="badge">&nbsp;
				<?php echo $tarefa; ?><strong><font color="#FF0000" face="Arial, Helvetica, sans-serif">
        <input type="hidden" name="txtid_hist" id="txtid_hist" value="<?php echo $tarefa; ?>"/>
        </font></strong>&nbsp;
			</span>
      </div>
    </td>
    <td width="18%" align="right"><label>Data:</label></td>
    
    <td width="48%">
      <div class='col-sm-8'>
	      <input type='datetime' class="form-control" name="txtdata"  value="<?php echo $dttarefa; ?>" autofocus="autofocus"/>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" align="center"><font color="#003399" size="+1" face="Tahoma, Geneva, sans-serif"><strong>Histórico</strong></font></td>
    </tr>
  <tr>
    <td colspan="4" ><textarea name="txthistorico" cols="78" rows="5" class="form-control" id="txthistorico" style="text-transform:uppercase"></textarea></td>
    </tr>
  <tr>
    <td colspan="4" ><br />
      <button type="button" class="btn btn-sm btn-incluir" onclick="javascript:incluir_historico();"> 
      <i class="fas fa-plus" aria-hidden="true"></i> Incluir Histórico </button>
      <button type="button" class="btn btn-sm btn-voltar" onclick="javascript:window.history.back();">
        <i class="fas fa-remove-circle"></i> Fechar
      </button>
    </tr>
  </table>
</form>
<?php
include("../utilitarios/rodape-fixo.php");
?>
</body>
</html>