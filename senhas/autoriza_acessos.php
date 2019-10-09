<?php 
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
require_once('../utilitarios/funcoes.php');
$_SESSION['funcao'] = "Acessos ao Sistema";
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
<link href="../css/bootstrap.min.css" rel="stylesheet" />
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="../css/formata_textos.css" rel="stylesheet">
<link href="../css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../css/all.css"/>
<link rel="stylesheet" type="text/css" href="../css/botoes.css"/>
<script language="javascript" src="../js/users.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/carrega_ajax.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<title>Acessos ao Sistema</title>
</head>
<body>
<?php include_once("../utilitarios/cabecalho.php");?>

<form id="form1" name="form1" method="post">
<p></p>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td align="right"><label>Nome do Usuário</label>
          </td>
          <td>
            <div class="col-sm-6">
			<select class="form-control" name="txtusuario" id="txtusuario" autofocus onChange="buscaUser();">
				<option value="0">Selecione Usuário</option>
				<?php
				$sql = "select * from users order by nome";
				$mysql_query = $_con->query($sql);
				if ($mysql_query->num_rows>0) {
					while ($_row = $mysql_query->fetch_assoc()) {?>
						<option value="<?php echo $_row['usuario']; ?>"><?php echo $_row['nome']; ?></option>
				<?php
					}
				}?>
			</select>
            </div>
         </td>
          <td>
          </td>
      </tr>
      <tr>
        <td nowrap="nowrap" align="right"><label>Usuário:</label>
        </td>
        <td colspan="2">
          <div class="col-sm-6">
          <input name="txtnome" type="text" class="form-control" id="txtnome" size="60" maxlength="50" />
          </div>
        </td>
      </tr>
      <tr>
        <td nowrap="nowrap" align="right">
        </td>
        <td colspan="2"><br />
          <div class="col-sm-6">
            <button name="btnaltcomp" id="btnaltcomp" type="button" class="btn btn-success btn-sm" onclick="gravar_liberacoes();">
              <i class="fas fa-save" aria-hidden="true"></i> Gravar
              </button>
              <a href="javascript:voltaPag('index.php');" class="btn btn-voltar btn-sm" role="button"><i class="fas fa-arrow-left" aria-hidden="true"></i> Voltar</a><br></div>
        </td>
      </tr>
      <tr>
      	<td colspan="3">
			<p>
      		<?php
				if(isset($_SESSION['msg'])){
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}
			?></p>
      	</td>
      </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
              <div id="liberacoes">
              </div>
          </td>
        </tr>
      </table>
	</td>
  </tr>
</table>
</form>
<?php include_once("../utilitarios/rodape-fixo.php");?>
</body>
</html>