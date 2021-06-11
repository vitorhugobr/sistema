<?php
include_once("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a p&Aacute;gina
$_SESSION['funcao'] = "Senhas";
include_once("../utilitarios/funcoes.php");
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
<link href="../css/botoes.css" rel="stylesheet">
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script type="text/javascript" src="../js/senhas.js"></script>
<script src="../js/carrega_ajax.js" type="text/javascript"></script>
<script src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<title>Cadastro Senhas</title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include_once("../utilitarios/cabecalho.php");?>
<form method="post" name="form1" id="form1">
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
                echo '<li class="nav-item"><input type="button" name="Button2" class="btn btn-success btn-sm" value="Alterar" onClick="grava_senha()"></li>';
                echo '<li class="nav-item"><input type="button" name="Button2" class="btn btn-limpatela btn-sm" value="Limpa Tela" onClick="limpa_tela()"></li>';
                ?>
              <li class="nav-item">
                  <input type="button" name="Button2" class="btn btn-voltar btn-sm" value="Voltar" onClick="voltaPag('index.php')">
              </li>
          </ul>
      </div>
   	</div>
   </nav>
	<?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
?>
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1">
      
    <?php 
	if ($_SESSION['usuarioNivel'] < 2) {
	  echo '<tr>
			  <td width="18%" align="right">
				<label>Usuário:
				</label>
			  </td>
			  <td width="82%">
			  	<div class="col-sm-6">
				<input name="txtUser" type="text" class="form-control" id="txtUser" size="70" maxlength="70" autofocus="autofocus" autocomplete="off">
				<input type="hidden" name="txtCodigo" id="txtCodigo" />
				</div>
			  </td>
			</tr>
			<tr>
			  <td align="right">
				<label>Nome:
				</label>
			  </td>
			  <td>
			  	<div class="col-sm-6">
				  <input name="txtnome" type="text" class="form-control" id="txtnome" size="50" maxlength="60" autocomplete="off">
				</div>
			  </td>
			</tr>
			<tr>
			  <td align="right">
				<label>Nível:
				</label>
			  </td>
			  <td>
  			  	<div class="col-sm-2">
				  <select name="txtNivel" class="form-control" id="txtNivel">
						<option value="2">Gabinete</option>
						<option value="1">Administrador</option>
						<option value="9">Usuário Web</option>
				  </select>
				</div>
			  </td>
			</tr>';
	}else{
	   echo'<tr>
			  <td width="18%" align="right">
				<label>Usuário:
				</label>
			  </td>
			  <td width="82%">
  			  	<div class="col-sm-4">
				  <span class="form-control">'.$_SESSION['usuarioUser'].'
				  </span>
				  <input type="hidden" name="txtCodigo" id="txtCodigo" value="'.$_SESSION['usuarioCodigo'].'" />
				  <input type="hidden" name="txtNivel" id="txtNivel" value="'.$_SESSION['usuarioNivel'].'" />
				</div>
			  </td>
			</tr>
			<tr>
			  <td align="right">
				<label>Nome:
				</label>
			  </td>
			  <td>
			  	<div class="col-sm-6">
				  <span class="form-control">'.$_SESSION['usuarioNome'].'
				  </span>
				</div>
			  </td>
			</tr>';
		  }
	?>
    <tr>
      <td align="right"><label>Senha:</label></td>
      <td>
      	<div class="col-sm-6">
        <input name="txtSenha0" type="password" class="form-control" id="txtSenha0" size="50" maxlength="50" autocomplete="off">
        </div>
      </td>
    </tr>
    <tr>
    <tr>
      <td nowrap="nowrap" align="right"><label>Confirma Senha:</label></td>
      <td>
      	<div class="col-sm-6">
      	<input name="txtSenha1" type="password" class="form-control" id="txtSenha1" size="50" maxlength="50" autocomplete="off">
        </div>
      </td>
    </tr>
      <tr>
        <td width="10">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    <tr>
      <td align="center"></td>
      <td align="center"></td> 
    </tr>
  </table>
</form>
<?php include_once("../utilitarios/rodape-fixo.php");?>
<script type="text/javascript">
  new Autocomplete("txtUser", function() { return "autocomplete_user.php?typing=" + this.text.value;});
</script>

</body>
</html>