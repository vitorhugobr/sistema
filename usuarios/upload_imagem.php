<?php
  include_once("../seguranca.php");
  protegePagina();
 
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Cadastro de árbitros">
  <meta name="author" content="Vitor H M Oliveira">
  <link rel="stylesheet" type="text/css" href="../css/ajax.css"/>
  <link rel="SHORTCUT ICON" href="../imagens/vhmo.png" />
  <link rel="stylesheet" type="text/css" href="../css/formata_textos.css"/> 
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link href="../css/all.min.css" rel="stylesheet">
  <link href="../css/botoes.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <title>Upload Imagem</title>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
  <script type="text/javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/ie-emulation-modes-warning.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <script>
function pesquisarusuario(usu) {
	var usuario = usu;
	AjaxRequest();
	if(!Ajax) {
		alert('não foi  possível iniciar o AJAX');
		return;
	}
//	alert(usuario);
	ajax3('busca_user.php?user='+usuario,'carregando');


}			

</script>

  </head>
  <body>
<?php include_once("../utilitarios/cabecalho.php");?>
<?php
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>
 <div class="container">
  <form action="proc_upload.php" method="post" enctype="multipart/form-data" name="form1" >
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
  	<td width="50%" height="165" align="center">
      <h6>Inclusão Foto </h6>
      <input type="hidden" id="txtcodigo" name="txtcodigo">
			<select class="form-control" name="txtusuario" id="txtusuario" autofocus onChange="pesquisarusuario(this.value);">
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
	  <br>
      <input type="file" name="foto" id="foto" disabled/><br>
      <br />
      <button type="submit" name="sendfoto" id="sendfoto" class="btn btn-upload btn-sm" disabled><span class="fas fa-image"></span> Enviar</button>
	  <button type="button" class="btn btn-sm btn-voltar" onclick="voltaPag('../senhas/index.php')">
		<i class="fas fa-backward" aria-hidden="true text-muted" aria-hidden="true"></i> Voltar
	  </button>
      </td>
  	<td width="62%" valign="top" class="alert-warning" align="center"><p><br />
  	  Fotos deverão ter extensão jpg</p>
  	  <p>Largura máxima: 1500 px</p>
  	  <p>Altura máxima: 2000 px</p>
  	  <p>Tamanho máximo da imagem: 30000 px<br />
  	  </p></td>
  </tr>
  </table>
  <h3>&nbsp;</h3>
  </form>
  </div>
<?php include_once("../utilitarios/rodape-fixo.php")
  ?>
    </body>
</html>