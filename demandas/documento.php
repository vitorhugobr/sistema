<?php
  include_once("../seguranca.php");
  protegePagina();
  include_once("../utilitarios/funcoes.php");
 
 $demanda = filter_input(INPUT_GET, 'demanda',FILTER_DEFAULT);
 $_SESSION['funcao']="Upload Arquivos";

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
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/ajax.js"></script>
  <script type="text/javascript" src="../js/carrega_ajax.js"></script>
  <script src="../js/ie-emulation-modes-warning.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <script>
  //-------------------------------------------------------------------------------------------------------------
  </script>
  <title>Upload Documento</title>
  </head>
  <body>
  <?php include_once("../utilitarios/cabecalho.php"); ?>
  <div class="container">
  <form action="salvar_doc.php?demanda=<?php echo $demanda; ?>" method="post" enctype="multipart/form-data" name="form1" ><br />
	<input type="hidden" name="txtdemanda" value="<?php echo $demanda; ?>">
	<input type="hidden" name="enviou" value="1">
	Arquivo PDF:<br>
	<input type="file" name="arquivo">
	<button type="submit" class="btn btn-sm btn-upload">
		<i class="fas fa-file-upload" aria-hidden="true"></i> Enviar
	</button>
	<button type="button" class="btn btn-sm btn-cancelar" onClick="self.window.close();">
		<i class="fas fa-window-close" aria-hidden="true"></i> Cancelar
	</button>
  </form>
</div>
 <?php include_once("../utilitarios/rodape-fixo.php")
  ?>
 </body>
</html>