<?php
  include_once("../seguranca.php");
  protegePagina();
  include_once("../utilitarios/funcoes.php");
 
 $seq = filter_input(INPUT_GET, 'seq',FILTER_DEFAULT);
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
  <link rel="stylesheet" type="text/css" href="../css/sticky-footer-navbar.css"/>
  <link href="../css/all.css" rel="stylesheet">
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
  <script type="text/javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/ie-emulation-modes-warning.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <title>Carregar Imagem</title>
  </head>
  <body>
  <div id="carregando"></div>
  <form action="salvar_imagem_cadastro.php" method="post" enctype="multipart/form-data" name="form1" ><br />
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
  	<td width="50%" height="165" align="center">
      <h4>Inclusão Imagem </h4>

      	<input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>">
      <input type="file" name="foto"/>
      <br />
      <button type="submit" name="sendfoto" id="sendfoto" class="btn btn-upload btn-sm"><span class="fas fa-image"></span> Enviar</button>

		<button type="button" class="btn btn-sm btn-cancelar" onClick="self.window.close();"><i class="fas fa-window-close" aria-hidden="true"></i> Cancelar
		</button>
      </td>
  	<td width="62%" valign="top" class="alert-warning" align="center"><p><br />
  	  Imagens deverão ter extensão jpg</p>
  	  <p>Largura máxima: 300 px</p>
  	  <p>Altura máxima: 350 px</p>
  	  <p>Tamanho máximo da imagem: 310 k<br />
  	  </p></td>
  </tr>
  </table>
  <h3>&nbsp;</h3>
  </form>
<?php include_once("../utilitarios/rodape-fixo.php")
  ?>
    </body>
</html>