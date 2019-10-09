<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
require_once ('../utilitarios/funcoes.php');

if (liberado(4501)==0){
	expulsaVisitante2();
}

$_SESSION['funcao'] = "Tarefas - Inclusão";

$sql = "select * from users order by usuario";
$mysql_query = $_con->query($sql);
$combo = '<select name="txtnomeusuario" class="form-control" onChange="javascript:busca_usuario(this.value);">\n';

$combo .= " <option value='0'> </option>\n";
if ($mysql_query->num_rows>0) {
	while ($_row = $mysql_query->fetch_assoc()) {
			//concatenamos e damos o valor da option
			$combo .= " <option value='".$_row['codigo'];
			//concatenamos e inserimos o dado que se mostrara
			$combo .= "'>".$_row['usuario']."</option>\n";
	}
}
//concatenamos e fechamos o select
$combo .= "</select>\n";

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
<link href="../css/all.css" rel="stylesheet">
<link href="../css/botoes.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<script language="javascript" src="../js/tarefas.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/ie-emulation-modes-warning.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/ie10-viewport-bug-workaround.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php include_once("../utilitarios/cabecalho.php");?>
<?php
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<form name="form1" method="post" action="">
<table class="table table-sm table-borderless">
<tr>
<td align="right"><strong>Usuário:</strong></td>
<td colspan="3">
	<div class="col-3">
		<?php echo $combo; ?>
	</div>
  <input name="txtusuario" type="hidden" id="txtusuario"/>      
</td>
<tr>
<td align="right"><strong>Prioridade:</strong></td>
<td colspan="3">
	<div class="col-3">
	<select name="txtprioridade" class="form-control" id="txtprioridade">
	<option value="1">Baixa</option>
	<option value="2">Média</option>
	<option value="3">Alta</option>
	</select>
	</div>
</td>
</tr>
</tr>
<tr>
<td align="right"><strong>Assunto:</strong></td>
<td colspan="3">
	<div class="col-3">
		<input name="txtassunto" type="text" class="form-control" id="txtassunto" size="50" maxlength="50" /></td>
	</div>
</tr>
<tr>
<td align="right" valign="top"><strong>Tarefa:</strong></td>
<td colspan="3">
	<div class="col-10">
	  <textarea name="txttarefa" cols="150" rows="5" class="form-control" id="txttarefa"></textarea></td>
	</div>
</tr>
<tr>
<td align="right" valign="top"><strong>Enviar e-mail:</strong></td>
<td colspan="3" align="left" valign="top">
	<div class="col-12">
		<div class="row">
		<div class="col-1">
			<input type="checkbox" class=" form-controlform-check-inline" id="chkemail" name="chkemail">
		</div>
		<div class="col-11">
			<input class="form-control-plaintext" name="txtemail" type="text" id="txtemail" readonly/>
		</div>
		</div>
	</div>
  </td>
</tr>
<tr>
<td colspan="4" align="center">
		<button type="button" class="btn btn-sm btn-incluir" onclick="javascript:incluir_tarefa();">
			<i class="fas fa-plus" aria-hidden="true"></i> Incluir Tarefa
		</button>
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